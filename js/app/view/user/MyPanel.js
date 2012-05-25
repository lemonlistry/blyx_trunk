Ext.define('Platform.view.user.MyPanel', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.MyPanel',
    width: 400,
    height: 300,
    layout: 'column',
    title: 'Container Panel',
    items: [
        {
            xtype: 'panel',
            title: 'child Panel 1',
            height: 100,
            width: '50%',
        },
        {
            xtype: 'panel',
            title: 'child Panel 2',
            height: 100,
            width: '50%'
        }
    ]
});
