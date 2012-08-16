/**
 * ovrride 'Ext.chart.LegendItem'
 */
Ext.override(Ext.chart.LegendItem, {
	updatePosition : function(relativeTo) {
		var me = this, items = me.items, ln = items.length, i = 0, item;
		if (!relativeTo) {
			relativeTo = me.legend;
		}
		// modify start
		if (me.legend.height > 0 && me.y > me.legend.maxY) {
			var r = Math.ceil((me.y - me.legend.maxY) / me.legend.offsetY);
			me.x += me.legend.columnWidth * r;
			me.y -= me.legend.offsetY * r;
		}
		// modify end
		for (; i < ln; i++) {
			item = items[i];
			switch (item.type) {
				case 'text' :
					item.setAttributes({
						x : 20 + relativeTo.x + me.x,
						y : relativeTo.y + me.y
					}, true);
					break;
				case 'rect' :
					item.setAttributes({
						translate : {
							x : relativeTo.x + me.x,
							y : relativeTo.y + me.y - 6
						}
					}, true);
					break;
				default :
					item.setAttributes({
						translate : {
							x : relativeTo.x + me.x,
							y : relativeTo.y + me.y
						}
					}, true);
			}
		}
	}
});
/**
 * ovrride 'Ext.chart.Legend'
 */
Ext.override(Ext.chart.Legend, {
	createItems : function() {
		var me = this, chart = me.chart, surface = chart.surface, items = me.items, padding = me.padding, itemSpacing = me.itemSpacing, spacingOffset = 2, maxWidth = 0, maxHeight = 0, totalWidth = 0, totalHeight = 0, vertical = me.isVertical, math = Math, mfloor = math.floor, mmax = math.max, index = 0, i = 0, len = items ? items.length : 0, x, y, spacing, item, bbox, height, width;
		if (len) {
			for (; i < len; i++) {
				items[i].destroy();
			}
		}   items.length = [];   chart.series.each(function(series, i) {
			if (series.showInLegend) {
				Ext.each([].concat(series.yField), function(field, j) {
					item = Ext.create('Ext.chart.LegendItem', {
						legend : this,
						series : series,
						surface : chart.surface,
						yFieldIndex : j
					});
					bbox = item.getBBox();
					width = bbox.width;
					height = bbox.height;   if (i + j === 0) {
						spacing = vertical ? padding + height / 2 : padding;
					} else {
						spacing = itemSpacing / (vertical ? 2 : 1);
					}   item.x = mfloor(vertical ? padding : totalWidth + spacing);
					item.y = mfloor(vertical ? totalHeight + spacing : padding + height / 2);
					totalWidth += width + spacing;
					totalHeight += height + spacing;
					maxWidth = mmax(maxWidth, width);
					maxHeight = mmax(maxHeight, height);   items.push(item);
				}, this);
			}
		}, me);   me.width = mfloor((vertical ? maxWidth : totalWidth) + padding * 2);
		if (vertical && items.length === 1) {
			spacingOffset = 1;
		}
		me.height = mfloor((vertical ? totalHeight - spacingOffset * spacing : maxHeight) + (padding * 2));
		me.itemHeight = maxHeight;
		// modify start
		var outerHeight = me.chart.curHeight - 20;
		if (items.length >= 2 && me.height > outerHeight) {
			var row = math.floor((outerHeight - padding * 2) / (items[1].y - items[0].y));
			if (row > 0) {
				me.columnWidth = me.width;
				me.width *= math.ceil(items.length / row);
				me.height = outerHeight;
				me.offsetY = items[row].y - items[0].y;
				me.maxY = items[row - 1].y;
			}
		}
		// modify end
	}
});