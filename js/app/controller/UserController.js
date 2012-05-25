Ext.define('Platform.controller.UserController', {
    extend: 'Ext.app.Controller',

    init: function () {
        this.control({
            'viewport > userlist' : {
                itemdblclick: this.editUser
            },

            'useredit button[action=save]': {
                click: this.updateUser
            }
        });
    },

    views: ['user.List', 'user.Edit', 'user.MyPanel'],
    
    stores: ['Users'],

    models: ['User'],

    editUser: function (grid, record) {
        var view = Ext.widget('useredit');
        view.down('form').loadRecord(record);
    },

    updateUser: function (button) {
        var win = button.up('window');
        var form = win.down('form');
        var record = form.getRecord();
        var values = form.getValues();
        record.set(values);
        win.close();
        this.getUsersStore().sync();
    }
});
