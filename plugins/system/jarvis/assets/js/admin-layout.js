/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-layout.js 34 2014-08-30 05:08:31Z linhnt $
 */
(function($) {
	"use strict";

	function _restoreColumns(columns, parent) {
		var self = this;

		$.each(columns, function() {
			var
			column = self.makeColumn(false, true);
			column.data('column-settings', this.config);

			$.map(this.order, function(order, name) {
				column.attr('data-' + name + '-order', order);
			});

			if (this.position)
				column.attr('data-position', this.position);

			if (this.positionStyle)
				column.attr('data-position-style', this.positionStyle);

			if (this.items.length > 0)
				_restoreRows.call(self, this.items, column.find('> .jarvis-column-wrap > .jarvis-column-content'));
			
			parent.append(column);
		});
	};

	function _restoreRows(rows, parent) {
		var self = this;

		$.each(rows, function() {
			var
			row = self.makeRow();
			row.data('row-settings', this.config);
			row.data('layout-settings', this.layout);

			if (this.items.length > 0) {
				_restoreColumns.call(self, this.items, row.find('.jarvis-row-content'));
			}

			parent.append(row);
		});
	}

	/**
	 * Layout builder class
	 */
	function LayoutBuilder(elm, opts) {
		this.elm = $(elm);
		this.toolbar = this.elm.find('> .jarvis-layout-toolbar');
		this.container = this.elm.find('> .jarvis-layout-container');

		this.opts = $.extend({
			data: [],
			parent: null,
			change: function() {}
		}, opts);

		// Initialize
		this.create();

		if (this.opts.data.length > 0) {
			var self = this;

			$.each(this.opts.data, function() {
				var
				section = self.makeSection();
				section.data('row-settings', this.config);
				section.data('layout-settings', this.layout);

				if (this.items.length > 0) {
					_restoreColumns.call(self, this.items, section.find('.jarvis-layout-section-content'));
				}

				self.btnAddRow.before(section);
			});

			$('.jarvis-row-content, .jarvis-layout-section-content', this.container).columnResizer({
				screenSize: $.proxy(this.screenSize, this),
				items: '> .jarvis-column',
				resized: $.proxy(self.columnResized, self)
			});

			this.reorderColumns();
			this.container.find('.jarvis-layout-section, .jarvis-row').each((function(index, row) {
				this.updateColumnsWidth($(row));
			}).bind(this));
		}
	};

	LayoutBuilder.prototype = {
		/**
		 * Method to prepare UI for layout builde,
		 */
    
		create: function() {
      var self = this;
			// Create the toolbar element
			this.btnAddRow = $('<button />', {
				type: 'button'
			}).text('Add Section');

			// Add toolbar element to the container
			this.container.append(this.btnAddRow);
			this.container.sortable({
				items: '> .jarvis-layout-section',
				handle: '> .jarvis-layout-section-header',
				axis: 'y',
        update: function(event, ui) {
          self.opts.change(self);
        }
			});

			this.container.attr('data-screen-size',
				this.toolbar.find('input[name="screen-size"]:checked').val()
			);

			/**
			 * Register events
			 */
			this.btnAddRow.on('click', $.proxy(function() {
				this.btnAddRow.before(
					this.makeSection()
				);
				this.opts.change(this);
			}, this));

			// Register click event for all elements have 
			// attribute "data-command"
			this.elm.on('click', '[data-command]', $.proxy(function (e){
				e.preventDefault();

				var target = $(e.target),
				command = target.attr('data-command');

				if (command === undefined) {
					target = target.closest('[data-command]');
					command = target.attr('data-command');
				}

				// Execute the command that associated 
				// with target element
				this.execCommand(
					command,
					target.closest('.jarvis-layout-section, .jarvis-row, .jarvis-column, .jarvis-layout-container'),
					target
				);
			}, this));

			// Set current screen size
			this.toolbar.on('change', 'input[name="screen-size"]', $.proxy(function() {
				this.container.attr('data-screen-size',
					this.toolbar.find('input[name="screen-size"]:checked').val()
				);

				this.reorderColumns();
				this.container.find('.jarvis-layout-section, .jarvis-row').each((function(index, row) {
					this.updateColumnsWidth($(row));
				}).bind(this));
			}, this));
		},

		/**
		 * Execute given comman,
		 */
		execCommand: function(command, element, button) {
			if (typeof(this[command]) != 'function')
				return false;

			this[command].call(this, element, button);

			// Serialize after execute command
			this.opts.change(this);
		},

		/**
		 * Return current checked screen size
		 */
		screenSize: function() {
			return this.toolbar.find('input[name="screen-size"]:checked').val();
		},

		/**
		 * Create an section element from the templat,
		 */
		makeSection: function() {
			var
			row = this.template('section-template');
			row.data('layout-settings', this.defaultRowLayout());
			row.data('row-settings', {
				visibility: ['large', 'medium', 'small', 'xsmall']
			});
			row.find('.jarvis-layout-section-header').append(this.template('section-toolbox-template'));
			row.find('.jarvis-layout-section-content').sortable({
				connectWith: '.jarvis-layout-section-content',
				items: '> .jarvis-column',
				handle: '> .jarvis-column-wrap > .jarvis-column-header',
				tolerance: "pointer",
				helper: 'clone',
				start: $.proxy(this.beforeSortColumns, this),
				stop: $.proxy(this.afterSortColumns, this)
			});

			return row;
		},

		/**
		 * Create a row from the templat,
		 */
		makeRow: function() {
			var
			row = $('<div class="jarvis-row">\
						<div class="jarvis-row-header"></div>\
						<div class="jarvis-row-content"></div>\
					</div>');

			row.data('layout-settings', this.defaultRowLayout());
			row.data('row-settings', {
				visibility: ['large', 'medium', 'small', 'xsmall']
			});
			row.find('.jarvis-row-header').append(this.template('row-toolbox-template'));
			row.find('.jarvis-row-content').sortable({
				connectWith: '.jarvis-row-content',
				items: '> .jarvis-column',
				handle: '> .jarvis-column-wrap > .jarvis-column-header',
				tolerance: "pointer",
				helper: 'clone',
				start: $.proxy(this.beforeSortColumns, this),
				stop: $.proxy(this.afterSortColumns, this)
			});

			return row;
		},

		template: function(id) {
			return $($(document.getElementById(id)).html());
		},

		/**
		 * Create an column from the templat,
		 */
		makeColumn: function(order, sortable) {
			var
			column = this.template('column-template');
			column.data('column-settings', {
				visibility: ['large', 'medium', 'small', 'xsmall']
			});
			column.find('.jarvis-column-header').append(this.template('column-toolbox-template'));

			if ($.isPlainObject(order)) {
				$.map(order, function(order, size) {
					column.attr('data-' + size + '-order', order);
				});
			}

			if (sortable !== undefined && sortable == true) {
				column.find('> .jarvis-column-wrap > .jarvis-column-content')
				.sortable({
					connectWith: '.jarvis-column-content',
					items: '> .jarvis-row',
					handle: '> .jarvis-row-header'
				});
			}

			return column;
		},

		editRow: function(element, button) {
			this.editDialog = this.template('edit-row-template');
			this.editDialog.dialog({
				title: 'Row Settings',
				modal: true,
				width: 600,
				open: $.proxy(function(event, ui) {
					var
					data = element.data('row-settings');
					console.log(data);

					if (data !== undefined) {
						this.editDialog.find('form').populate(data);
					}

					SqueezeBox.assign(this.editDialog.get(0).querySelectorAll('a.modal'), {
						parse: 'rel'
					});

					this.editDialog.find('.jarvis-color-picker').colorPicker();
					this.editDialog.find('.jarvis-buttonset').buttonset();
					this.editDialog.on('click', '[data-command="save"]', $.proxy(function() {
						var
						data = this.editDialog.find('form').serializeForm();
						element.data('row-settings', data);

						this.editDialog.dialog('close');
					}, this));
					this.editDialog.on('click', '[data-command="cancel"]', $.proxy(function() {
						this.editDialog.dialog('close');
					}, this));
				}, this),
				close: $.proxy(function() {
					// Destroy popup elements
					this.editDialog.dialog('destroy');
					this.editDialog.remove();

					this.opts.change(this);
				}, this)
			});

			this.editDialog.closest('.ui-dialog').addClass('jarvis');
		},

		editLayout: function(element, button) {
			this.layoutDialog = this.template('edit-row-layout-template');
			this.layoutDialog.dialog({
				title: 'Layout Settings',
				modal: true,
				width: 800,
				position: 'center',

				open: $.proxy(function(event, ui) {
					var
					data		= element.data('layout-settings') || {},
					screenSize	= this.screenSize(),
					columnCount	= 0;

					if (element.hasClass('jarvis-layout-section'))
						columnCount = $('> .jarvis-layout-section-content > .jarvis-column', element).length;
					else
						columnCount = $('> .jarvis-row-content > .jarvis-column', element).length;

					$('.jarvis-tabs', this.layoutDialog).tabs();
					$('.jarvis-buttonset', this.layoutDialog).buttonset();

					$('form', this.layoutDialog).on('change', function() {
						$('[data-screen-size]', this).attr('data-screen-size',
							$('input[name="screensize"]:checked').val()
						);
					}).populate({
						screensize: screenSize
					});

					$('[data-screen-size]', this.layoutDialog).attr({
						'data-column-count': columnCount,
						'data-screen-size': screenSize
					});

					for (var index = 1; index <= 6; index++) {
						var
						columnWidth = Math.floor(12/index),
						rowLayout = data[index] || {
							'large': {},
							'medium': {},
							'small': {},
							'xsmall': {}
						},

						row			= $('<div class="jarvis-row"><div class="jarvis-row-content"></div></div>'),
						rowContent	= row.find('.jarvis-row-content');

						row.appendTo($('.jarvis-layout-container', this.layoutDialog));
						rowContent.append(
							$('<span class="jarvis-columns-count"></span>').text(index)
						);

						for (var columnIndex = 1; columnIndex <= index; columnIndex++) {
							rowContent.append(
								$('<div class="jarvis-column" />').attr({
									'data-large-width': rowLayout['large'][columnIndex-1] || columnWidth,
									'data-medium-width': rowLayout['medium'][columnIndex-1] || columnWidth,
									'data-small-width': rowLayout['small'][columnIndex-1] || columnWidth,
									'data-xsmall-width': rowLayout['xsmall'][columnIndex-1] || columnWidth
								}).append(
									$('<div class="jarvis-column-wrap"><div class="jarvis-column-content"></div></div>')
								)
							);
						}

						rowContent.columnResizer({
							builder: this,
							screenSize: $.proxy(function() {
								return $('.jarvis-layout-container', this.layoutDialog).attr('data-screen-size');
							}, this),
							items: '> .jarvis-column'
						});
					}

					this.layoutDialog.on('click', '[data-command="save"]', $.proxy(function() {
						var rowLayout = {};

						$('.jarvis-row', this.layoutDialog).each(function(index, row) {
							var columns = $('.jarvis-column', this),
							layout = {};

							$.each(['large', 'medium', 'small', 'xsmall'], function(screenIndex, screensize) {
								layout[screensize] = {};

								columns.each(function(columnIndex, column) {
									layout[screensize][columnIndex] = $(column).attr('data-' + screensize + '-width');
								});
							});

							rowLayout[index + 1] = layout;
						});

						element.data('layout-settings', rowLayout);

						this.updateColumnsWidth(element);
						this.layoutDialog.dialog('close');
					}, this));

					this.layoutDialog.on('click', '[data-command="cancel"]', $.proxy(function() {
						this.layoutDialog.dialog('close');
					}, this));
				}, this),

				close: $.proxy(function() {
					// Destroy popup elements
					this.layoutDialog.dialog('destroy');
					this.layoutDialog.remove();

					this.opts.change(this);
				}, this)
			});

			this.layoutDialog.closest('.ui-dialog').addClass('jarvis');
		},

		editColumn: function(element, button) {
			this.editDialog = this.template('edit-column-template');
			this.editDialog.dialog({
				title: 'Column Settings',
				modal: true,
				width: 600,
				open: $.proxy(function(event, ui) {
					var
					data = element.data('column-settings');

					if (data !== undefined) {
						this.editDialog.find('form').populate(data);
					}

					this.editDialog.find('.jarvis-buttonset').buttonset();
					this.editDialog.on('click', '[data-command="save"]', $.proxy(function() {
						var
						data = this.editDialog.find('form').serializeForm();
						element.data('column-settings', data);

						this.editDialog.dialog('close');
					}, this));
					this.editDialog.on('click', '[data-command="cancel"]', $.proxy(function() {
						this.editDialog.dialog('close');
					}, this));
				}, this),
				close: $.proxy(function() {
					// Destroy popup elements
					this.editDialog.dialog('destroy');
					this.editDialog.remove();

					this.opts.change(this);
				}, this)
			});

			this.editDialog.closest('.ui-dialog').addClass('jarvis');
		},

		mapPosition: function(element, button) {
			var self = this;

			button.mapPosition({
				active: element.attr('data-position') || 'none',
				activeStyle: element.attr('data-position-style') || 'none',
				positions: this.opts.positions,
				template: this.opts.parent.options.template,
				selected: function(position, style) {
					position == 'none'
					? element.removeAttr('data-position')
					: element.attr('data-position', position);

					style == 'none'
					? element.removeAttr('data-position-style')
					: element.attr('data-position-style', style);	  				

					self.opts.change(self);
				}
			});
		},

		/**
		 * Add new row element to the builde,
		 */
		addRow: function(element, button) {
			element.hasClass('jarvis-layout-container')
			? element.append(this.makeRow())
			: element.find('> .jarvis-column-wrap > .jarvis-column-content').append(this.makeRow());

			element.addClass('jarvis-has-items');

			this.opts.change(this);
		},

		/**
		 * Add new column element to the builde,
		 */
		addColumn: function(element, button) {
			var self = this;

			if (element.hasClass('jarvis-layout-section')) {
				var
				sectionContent = element.find('> .jarvis-layout-section-content'),
				columnOrder = this.getColumnOrder(sectionContent),
				column = this.makeColumn(columnOrder, true);

				sectionContent
				.append(column)
				.sortable('refresh')
				.addClass('jarvis-has-items')
				.columnResizer({
					screenSize: $.proxy(this.screenSize, this),
					items: '> .jarvis-column',
					resized: $.proxy(this.columnResized, this)
				});

				element.attr('data-column-count', sectionContent.children().length);
			}
			else if(element.hasClass('jarvis-column')) {
				// Find the first row
				var
				row = element.find('> .jarvis-column-wrap > .jarvis-column-content > .jarvis-row:first-child');

				if (row.size() == 0) {
					row = this.makeRow();
					row.appendTo(element.find('> .jarvis-column-wrap > .jarvis-column-content'));
				}

				var
				rowContent = row.find('> .jarvis-row-content'),
				columnOrder = this.getColumnOrder(rowContent),
				column = this.makeColumn(columnOrder, false);

				rowContent
				.append(column)
				.columnResizer({
					screenSize: $.proxy(this.screenSize, this),
					items: '> .jarvis-column',
					resized: $.proxy(this.columnResized, this)
				});

				row.addClass('jarvis-has-items');
				row.attr('data-column-count', rowContent.children().length);
				element.addClass('jarvis-has-items');
			}
			else if(element.hasClass('jarvis-row')) {
				var
				rowContent = element.find('> .jarvis-row-content'),
				columnOrder = this.getColumnOrder(rowContent),
				column = this.makeColumn(columnOrder, false);

				rowContent
					.append(column)
					.columnResizer({
						screenSize: $.proxy(this.screenSize, this),
						items: '> .jarvis-column',
						resized: $.proxy(this.columnResized, this)
					});

				element.addClass('jarvis-has-items');
				element.attr('data-column-count', rowContent.children().length);
			}

			this.updateColumnsWidth(element);
			this.opts.change(this);
		},

		updateColumnsWidth: function(row) {
			var
			layout = row.data('layout-settings'),
			columns = row.find('> .jarvis-layout-section-content > .jarvis-column, > .jarvis-row-content > .jarvis-column');

			if (columns.length == 0 || layout === undefined)
				return;

			$.each(['large', 'medium', 'small', 'xsmall'], function() {
				for (var columnIndex = 0; columnIndex < columns.length; columnIndex++) {
					$(columns.get(columnIndex)).attr('data-' + this + '-width', layout[columns.length][this][columnIndex]);
				}
			});
		},

		columnResized: function(event, ui) {
			var
			row			= ui.element.closest('.jarvis-row, .jarvis-layout-section'),
			rowContent	= row.find('> .jarvis-row-content, > .jarvis-layout-section-content'),
			columnCount	= rowContent.children().length,
			rowLayout	= $.extend(this.defaultRowLayout(), row.data('layout-settings') || {}),
			screenSize	= this.screenSize();

			rowContent.children().each(function(index, column) {
				rowLayout[columnCount][screenSize][index] = $(column).attr('data-' + screenSize + '-width');
			});
			row.data('layout-settings', rowLayout);

			this.opts.change(this);
		},

		defaultRowLayout: function() {
			var layout = {};

			for (var length = 1; length <= 6; length++) {
				var columnWidth = Math.floor(12/length);
				layout[length] = {};

				$.each(['large', 'medium', 'small', 'xsmall'], function() {
					layout[length][this] = {};

					if (this == 'xsmall')
						columnWidth = 12;

					for (var columnIndex = 1; columnIndex <= length; columnIndex++) {
						layout[length][this][columnIndex-1] = columnWidth;
					}
				});
			}

			return layout;
		},

		beforeSortColumns: function(event, ui) {
			ui.placeholder.addClass('jarvis-column');
			ui.placeholder.attr({
				'data-large-width': ui.item.attr('data-large-width'),
				'data-medium-width': ui.item.attr('data-medium-width'),
				'data-small-width': ui.item.attr('data-small-width'),
				'data-xsmall-width': ui.item.attr('data-xsmall-width')
			});
		},

		afterSortColumns: function(event, ui) {
			// this.updateColumnsWidth(ui.item.closest('.jarvis-layout-section, .jarvis-layout-row'));
			var screenSize = this.screenSize(),
				columns = ui.item.parent().children();

			var row = ui.item.closest('.jarvis-layout-section, .jarvis-layout-row'),
				rowLayout = row.data('layout-settings');

			columns.each(function(index, column) {
				$(this).attr('data-' + screenSize + '-order', index);
				rowLayout[columns.length][screenSize][index] = $(column).attr('data-' + screenSize + '-width');
			});

			row.data('layout-settings', rowLayout);

			this.opts.change(this);
		},

		updateColumnIndex: function(container) {
			$.each(['large', 'medium', 'small', 'xsmall'], function(index, screenSize) {
				var sortedColumns = container.children().sort(function(column1, column2) {
					var column1Order = parseInt('0' + $(column1).attr('data-' + screenSize + '-order')),
					column2Order = parseInt('0' + $(column2).attr('data-' + screenSize + '-order'));

					if (column1Order < column2Order)
						return -1;
					else if (column1Order > column2Order)
						return 1;
					return 0;
				});

				sortedColumns.each(function(index, column) {
					$(column).attr('data-' + screenSize + '-order', index);
				});
			});
		},

		getColumnOrder: function(parent) {
			var
			self = this,
			columnIndex = {};

			self.toolbar.find('input[name="screen-size"]').each(function() {
				var
				maxIndex = -1,
				screenSize = this.value;

				parent.children().each(function() {
					var currentIndex = parseInt('0' + $(this).attr('data-' + screenSize + '-order'));

					if (currentIndex > maxIndex) {
						maxIndex = currentIndex;
					}
				});

				columnIndex[screenSize] = maxIndex + 1;
			});

			return columnIndex;
		},

		reorderColumns: function() {
			var
			self = this,
			screenSize = this.screenSize();

			this.container.find('.jarvis-layout-section-content, .jarvis-row-content')
				.each($.proxy(function(index, row) {
					var
					$row = $(row),
					$columns = $row.children().sort(function(first, second) {
						var
						firstOrder = parseInt('0' + $(first).attr('data-' + screenSize + '-order')),
						secondOrder = parseInt('0' + $(second).attr('data-' + screenSize + '-order'));

						return firstOrder - secondOrder;
					});

					$columns.detach();
					$columns.each(function() {
						$row.append(this);
					});
				}, this));
		},

		/**
		* Remove existed element from the builde,
		*/
		remove: function(element, button) {
			var
			row			= element.closest('.jarvis-row, .jarvis-layout-section'),
			rowContent	= element.closest('.jarvis-layout-section-content, .jarvis-row-content'),
			container	= element.closest('.jarvis-layout-section-content, .jarvis-row-content, .jarvis-column-content');

			element.remove();

			if (container.children().length == 0)
				container.closest('.jarvis-row, .jarvis-column, .jarvis-layout-section').removeClass('jarvis-has-items');

			row.attr('data-column-count', rowContent.children().length);

			this.updateColumnsWidth(row);
			this.updateColumnIndex(rowContent);
			this.opts.change(this);
		},

		serialize: function() {
			return this.serializeRows($('.jarvis-layout-section', this.container), '> .jarvis-layout-section-content > .jarvis-column');
		},

		serializeRows: function(items, childSelector) {
			var data = [],
			self = this;

			items.each(function() {
				data.push({
					type: 'row',
					config: $(this).data('row-settings'),
					layout: $(this).data('layout-settings'),
					items: self.serializeColumns($(this).find(childSelector))
				});
			});

			return data;
		},

		serializeColumns: function(items) {
			var data = [],
			self = this;

			items.each(function() {
				var config = $(this).data('column-settings'),
				position = $(this).attr('data-position'),
				positionStyle = $(this).attr('data-position-style'),
				order = {
					large: $(this).attr('data-large-order'),
					medium: $(this).attr('data-medium-order'),
					small: $(this).attr('data-small-order'),
					xsmall: $(this).attr('data-xsmall-order')
				};

				data.push({
					type: 'column',
					config: config,
					order: order,
					position: position,
					positionStyle: positionStyle,
					items: self.serializeRows(
						$(this).find('> .jarvis-column-wrap > .jarvis-column-content > .jarvis-row'), '> .jarvis-row-content > .jarvis-column'
					)
				});
			});

			return data.sort(function(column1, column2) {
				if (column1.order.xsmall < column2.order.xsmall)
					return -1;
				else if (column1.order.xsmall > column2.order.xsmall)
					return 1;
				return 0;
			});
		},

		change: function() {
			this.opts.change(this);
		}
	};

	var ColumnResizer = function(elm, opts) {
		this.elm = elm;
		this.opts = $.extend({
			screenSize: 'large',
			items: '> .column',
			resizing: function() {},
			resized: function() {}
		}, opts);

		this.create();
	};

	ColumnResizer.prototype = {
		create: function() {
			this.items()
				.resizable({
					handles: 'e',
					start: $.proxy(this.initResize, this),
					resize: $.proxy(this.doResize, this),
					stop: $.proxy(this.endResize, this)
				});
		},

		initResize: function(event, ui) {
			this.parentWidth = this.elm.width();
			this.stepWidth = Math.floor(this.parentWidth / 12);
			this.screenSize = (typeof(this.opts.screenSize) == 'function')
			? this.opts.screenSize()
			: this.opts.screenSize;
		},

		doResize: function(event, ui) {
			var
			newWidth = Math.round(ui.size.width / this.stepWidth);

			if (newWidth < 1) newWidth = 1;
			if (newWidth > 12) newWidth = 12;

			ui.element.attr('data-' + this.screenSize + '-width', newWidth);
			ui.element.removeAttr('style');

			this.opts.resizing(event, ui);
		},

		endResize: function(event, ui) {
			ui.element.addClass('jarvis-column-resized');
			this.opts.resized(event, ui);
		},

		items: function() {
			return this.elm.find(this.opts.items);
		}
	};

	/**
	 * Register plugin to jQuery
	 */
	$.fn['layoutBuilder'] = function(options) {
		return this.each(function() {
			$(this).data('layoutBuilder',
				new LayoutBuilder(this, options)
			);
		});
	};

	$.fn['columnResizer'] = function(opts) {
		return this.each(function() {
			$(this).data('columnResizer',
				new ColumnResizer($(this), opts)
			);
		});
	};

	$.JarvisAdminLayout = function(parent, container) {
		var self = this;

		this.parent = parent;
		this.container = container;
		this.containerField = this.container.find('> input[type="hidden"]');
		this.gridPanel = this.container.find('.jarvis-layout-builder');

		var existingData = [];
		try { existingData = JSON.parse(this.containerField.val()); }
		catch(e) {}

		this.gridPanel.layoutBuilder({
			positions: this.parent.options.positions,
			parent: this.parent,
			data: existingData,
			change: function(builder) {
				self.containerField.val(
					JSON.stringify(builder.serialize())
				);
			}
		});
	};
}).call(this, jQuery);