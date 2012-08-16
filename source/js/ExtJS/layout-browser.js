


Ext.define('Ext.ux.layout.Center', {
    extend: 'Ext.layout.container.Fit',
    alias: 'layout.ux.center',

    percentRe: /^\d+(?:\.\d+)?\%$/,

    itemCls: 'ux-layout-center-item',

    initLayout: function () {
        this.callParent(arguments);

        this.owner.addCls('ux-layout-center');
    },

    getItemSizePolicy: function (item) {
        var policy = this.callParent(arguments);
        if (typeof item.width == 'number') {
            policy = this.sizePolicies[policy.setsHeight ? 2 : 0];
        }
        return policy;
    },

    getPos: function (itemContext, info, dimension) {
        var size = itemContext.props[dimension] + info.margins[dimension],
            pos = Math.round((info.targetSize[dimension] - size) / 2);

        return Math.max(pos, 0);
    },

    getSize: function (item, info, dimension) {
        var ratio = item[dimension];

        if (typeof ratio == 'string' && this.percentRe.test(ratio)) {
            ratio = parseFloat(ratio) / 100;
        } else {
            ratio = item[dimension + 'Ratio']; // backwards compat
        }

        return info.targetSize[dimension] * (ratio || 1) - info.margins[dimension];
    },

    positionItemX: function (itemContext, info) {
        var left = this.getPos(itemContext, info, 'width');

        itemContext.setProp('x', left);
    },

    positionItemY: function (itemContext, info) {
        var top = this.getPos(itemContext, info, 'height');

        itemContext.setProp('y', top);
    },

    setItemHeight: function (itemContext, info) {
        var height = this.getSize(itemContext.target, info, 'height');

        itemContext.setHeight(height);
    },

    setItemWidth: function (itemContext, info) {
        var width = this.getSize(itemContext.target, info, 'width');

        itemContext.setWidth(width);
    }
});




function getBasicLayouts() {
 
    return {
      
        start: {
            id: 'start-panel',
            title: 'Start Page',
            layout: 'fit',
            bodyStyle: 'padding:8px',
            contentEl: 'start-div'  
        }

        
    };
}




Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', '../ux');
Ext.require([
    'Ext.tip.QuickTipManager',
    'Ext.container.Viewport',
    'Ext.layout.*',
    'Ext.form.Panel',
    'Ext.form.Label',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.tree.*',
    'Ext.selection.*',
    'Ext.tab.Panel',
    'Ext.ux.layout.Center'  
]);
Ext.onReady(function(){
    Ext.tip.QuickTipManager.init();
    var detailEl;
    var layoutExamples = [];
    Ext.Object.each(getBasicLayouts(), function(name, example) {
        layoutExamples.push(example);
    });
    
    var contentPanel = {
         id: 'content-panel',
         region: 'center',
         layout: 'card',
         margins: '2 5 5 0',
         activeItem: 0,
         border: false,
         items: layoutExamples
    };
     
    var store = Ext.create('Ext.data.TreeStore', {
        root: {
            expanded: true
        },
        proxy: {
            type: 'ajax',
            url: js_url_path+'/index.php?r=passport/default/treejson'
            //url: js_source_path+'/source/js/ExtJS/tree-data.json'
        }
    });
    
     var treePanel = Ext.create('Ext.tree.Panel', {
        id: 'tree-panel',
        region:'north',
        split: true,
        height: "100%",
        rootVisible: false,
        store: store
    });
    
    treePanel.getSelectionModel().on('select', function(selModel, record) {
    	if (record.get('leaf')) {
    		var title = getRootNode(record);
    		title = '您当前的位置： ' + title.join(',').split(',').reverse().join(' >> ');
    		var current_page = Ext.Cookies.get("currentPage");
    		var request_url = js_url_path + record.raw.url;
		    var c_name = page.getCookieName( js_url_path + current_page );
		    Ext.Cookies.clear(c_name);
			Ext.Cookies.set("currentPage", request_url);
			Ext.Cookies.set("currentTitle", title);  
			ContentTitleUpdate( title );
			updateContent( request_url );
        }
    });
    treePanel.expandAll()
    
    function getRootNode( node ){
    	var title = [];
    	title.push(node.raw.text);
    	if( typeof node.parentNode != 'undefined' && typeof node.parentNode.raw != 'undefined'){
    		title.push( getRootNode(node.parentNode) );
    	}
    	return title;
    }
    
    Ext.create('Ext.Viewport', {
        layout: 'border',
        title: 'Ext Layout Browser',
        items: [{
            xtype: 'box',
            id: 'header',
            region: 'north',
            html: '<h1 id="index-logo"> 菠萝游戏平台管理系统 '+top_admin,
            height: 30
        },{
            layout: 'border',
            id: 'layout-browser',
            title: '站点地图',
            region:'west',
            border: true,
            split:true,
            margins: '2 0 5 5',
            width: 235,
            height:'100%',
            collapsible : true,
            animCollapse:true,
            collapseDirection : 'left',
            //collapseMode: 'mini',
            items: [treePanel],
            listeners: {
                click: {
                    element: 'el',
                    fn: function(){}
                },
                afteritemcollapse: {
                    element: 'el', 
                    fn: function(){
                    	alert(1);
                    }
                }
            }
        }, 
            contentPanel
        ],
        renderTo: Ext.getBody()
    });
    (function(){
 	   var historyPage = Ext.Cookies.get("currentPage");
 	   var title = Ext.Cookies.get("currentTitle");
 	   if(historyPage==null || historyPage==''){
 		   historyPage = '';
 		   setContent({
 				src:js_url_path+'/index.php?r=passport/default/welcome'
 			});
 	   }else{
            setContent({
            	src:historyPage
            });
            ContentTitleUpdate(title);
            updateTreePos();
 	   }
    })();
    
    Ext.select('#index-logo').on('dblclick',function(e,t){
 	   var src = Ext.select('#right-content').elements[0].src;
 	   var _src =js_url_path+'/index.php?r=passport/default/welcome';
 	   console.log(_src);
 	   if(typeof t.href == 'undefined' && src.indexOf(_src)==-1){
 		   updateContent(_src);
 	   }
 	   Ext.Cookies.set("currentPage", _src);  
    });
    
    Ext.select('#start-panel_header').on('dblclick',function(){
    	var iframe = Ext.select('#right-content').elements[0];
 		resizeIframe( iframe );
    });
    
    function updateTreePos(){
        var pos = Ext.Cookies.get("currentPos");
        var tree =document.getElementById('treeview-1012'); 
        setTimeout(function(){
            tree.scrollTop = pos;
        },50);
    }

 	function ContentTitleUpdate( title ){
 		Ext.select('#start-panel_header span').update(title);
 	}
 	
 	function setContent(opt) {
 		var style=resizeIframe();
 		var iframe = '<iframe id="right-content" src="'+opt.src+'" style="'+style+'" frameborder="0"></iframe>';
 		Ext.get(Ext.query('#start-panel-body')).update(iframe);
 	}
 	function resizeIframe( iframe ){
 		var _body = Ext.get(Ext.query('#start-panel-body')).elements[0];
 		var w = parseInt(_body.style.width)-9*2,
 			h = parseInt(_body.style.height)-9*2;
 		var _style='height:'+h+'px;width:'+w+'px;border:none;';
 		if( typeof iframe == 'undefined'){
 			return _style;
 		}else{
 			iframe.style.cssText = _style;
 		}
 	}
 	function updateContent( url ) {
 		var iframe = Ext.select('#right-content').elements[0];
 		resizeIframe( iframe );
 		iframe.src=url;
 	}
});
