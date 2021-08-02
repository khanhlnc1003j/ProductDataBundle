pimcore.registerNS("pimcore.plugin.starfruit.productdata.bundle");

pimcore.plugin.starfruit.productdata.bundle = Class.create(pimcore.plugin.admin, {
    menuItems: null,

    menuInitialized: false,
    getClassName: function () {
        return "pimcore.plugin.starfruit.productdata.bundle";
    },

    initialize: function () {
         pimcore.plugin.broker.registerPlugin(this);
 
        this.navEl = Ext.get('pimcore_menu_search').insertSibling('<li id="pimcore_menu_mds" data-menu-tooltip="Starfruit" class="pimcore_menu_item pimcore_menu_needs_children"><img src="/bundles/productdata/img/starfruit.ico"></li>', 'after');
        this.menu = new Ext.menu.Menu({
            listeners: {
                "show": function (e) {
                    Ext.get('pimcore_menu_mds').addCls('active');
                },
                "hide": function (e) {
                    Ext.get('pimcore_menu_mds').removeCls('active');
                }
            },
            items: [{
                text: t('Version'),
                iconCls: "pimcore_nav_icon_info",
                handler: function () {
                    var dataExportMainTab = Ext.get("starfruit_version");
                    if (dataExportMainTab) {
                        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
                        tabPanel.setActiveItem("starfruit_version");
                    } else {
                        starfruit_version = new starfruit.bundle.productdata.versionPanel();
                    }
                }
            }, {
                text: t('Waiting for update!'),
                iconCls: "pimcore_icon_delete",
                // handler: function () {
                    
                // }
            }],
            cls: "pimcore_navigation_flyout"
        });
        pimcore.layout.toolbar.prototype.mdsMenu = this.menu;
    },

    pimcoreReady: function (params, broker) {
        var toolbar = pimcore.globalmanager.get("layout_toolbar");
        this.navEl.on("mousedown", toolbar.showSubMenu.bind(toolbar.mdsMenu));
        pimcore.plugin.broker.fireEvent("mdsMenuReady", toolbar.mdsMenu);
    },

    postOpenObject: function (object, type) {
        if (type == "object" && object.data.general.o_className == "OnlineShopOrder") {
            var tab = new pimcore.bundle.EcommerceFramework.OrderTab1(object, type);
      
            object.tab.items.items[1].insert(0, tab.getLayout());
            window.khanh = object.tab.items.items[1];
            object.tab.items.items[1].updateLayout();
            object.tab.items.items[1].setActiveTab(0);
            object.tab.items.items[1].remove(1);
            pimcore.layout.refresh();
        }
    }
});

new pimcore.plugin.starfruit.productdata.bundle();

