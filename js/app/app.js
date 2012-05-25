Ext.Loader.setConfig({
    enabled : true
});
Ext.application({
    name: 'Platform',
    appFolder: 'app',
    controllers: ['UserController'],
    launch: function () {
        Ext.create('Ext.container.Viewport', {
            //layout: 'fit',
            items: [
                {
                    xtype: 'MyPanel'
                }
            ]
        });
    }
});
