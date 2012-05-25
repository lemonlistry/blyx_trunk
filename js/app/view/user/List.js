Ext.define('Platform.view.user.List', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.userlist',
    title: 'All Users', 
    initComponent: function () {
        this.store = 'Users',

        this.columns = [
             {header: 'Name', dataIndex: 'name', flex: 1},
             {header: 'Email', dataIndex: 'email', flext: 1}
        ];
        this.callParent(arguments);
    }
});

