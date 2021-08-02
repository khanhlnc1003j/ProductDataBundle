pimcore.registerNS("starfruit.bundle.productdata.versionPanel");

starfruit.bundle.productdata.versionPanel = Class.create({

    initialize: function() {
        this.getLayout();
    },

    getLayout: function () {
        if (this.panel == null) {

            this.reloadButton = new Ext.Button({
                text: t("reload"),
                iconCls: "pimcore_icon_reload",
                // handler: this.reload.bind(this)
            });

            // this.openButton = new Ext.Button({
            //     text: t("open"),
            //     iconCls: "pimcore_icon_open",
            //     handler: function () {
            //         window.open(Ext.get("bundle_ecommerce_order_tab1_frame_" + this.id).dom.getAttribute("src"));
            //     }.bind(this)
            // });


            this.panel = Ext.create('Ext.panel.Panel', {
                id: "starfruit_version",
                title: t("Starfruit version"),
                iconCls: "pimcore_nav_icon_info",
                border: false,
                layout: "fit",
                closable: true,
                bodyStyle: "-webkit-overflow-scrolling:touch;",
                tbar: [this.reloadButton],
                html: '<iframe src="about:blank" frameborder="0" width="100%" id="iframe_starfruit_version"></iframe>',
            });
            this.panel.on("resize", this.onLayoutResize.bind(this));
            var tabPanel = Ext.getCmp("pimcore_panel_tabs");
            tabPanel.add(this.panel);
            tabPanel.setActiveItem(this.panel);

            pimcore.layout.refresh();

            Ext.get("iframe_starfruit_version").dom.src = '/admin/starfruit/order/order-detail/6';

        }

        return this.panel;

    },

    onLayoutResize: function (el, width, height, rWidth, rHeight) {
        this.setLayoutFrameDimensions(width, height);
    },

    setLayoutFrameDimensions: function (width, height) {
        Ext.get("iframe_starfruit_version").setStyle({
            height: height + "px"
        });
    },
});
