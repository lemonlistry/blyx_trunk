Ext.define('Platform.store.Users', {
    extend: 'Ext.data.Store',
    model: 'Platform.model.User',

    autoLoad: true,

    proxy: {
        type: 'ajax',
        api: {
            read: 'data/users.json',
            update: 'data/updateUsers.json'
        }, 
        reader: {
            type: 'json',
            root: 'users',
            successProperty: 'success'
        }
    }
});
