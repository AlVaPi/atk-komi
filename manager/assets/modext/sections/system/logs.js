Ext.onReady(function() {
    MODx.load({ xtype: 'modx-page-manager-log' });
});
/**
 * Loads the manager log page
 * 
 * @class MODx.page.ManagerLog
 * @extends MODx.Component
 * @param {Object} config An object of config properties
 * @xtype modx-page-manager-log
 */
MODx.page.ManagerLog = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        formpanel: 'modx-panel-manager-log'
        ,components: [{
            xtype: 'modx-panel-manager-log'
            ,renderTo: 'modx-panel-manager-log-div'
        }]
    });
    MODx.page.ManagerLog.superclass.constructor.call(this,config);
};
Ext.extend(MODx.page.ManagerLog,MODx.Component);
Ext.reg('modx-page-manager-log',MODx.page.ManagerLog);