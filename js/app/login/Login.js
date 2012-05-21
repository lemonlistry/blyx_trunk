Ext.application({
    name: 'HelloExt',
    launch: function () {
        Ext.create('Ext.container.Viewport', {
            layout: 'fit',
            items: [
                {
                    xtype: 'panel',
                    title: 'Hello Ext',
                    html: 'Hello! WelCome to Ext Js.' 
                }
            ]
        });
    }
});

