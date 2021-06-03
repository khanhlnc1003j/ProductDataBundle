pimcore.registerNS("pimcore.bundle.EcommerceFramework.OrderTab1");

pimcore.bundle.EcommerceFramework.OrderTab1 = Class.create({

    title: t('starfruit_ecommerce_order_tab'),
    iconCls: 'pimcore_icon_portlet_feed',
    src: null,
    id: null,

    initialize: function(object, type) {
        this.object = object;
        this.id = object.id;
        this.type = type;
        this.src = '/admin/starfruit/order/order-detail/'+this.id;
    },

    getLayout: function () {
        if (this.panel == null) {

            this.reloadButton = new Ext.Button({
                text: t("reload"),
                iconCls: "pimcore_icon_reload",
                handler: this.reload.bind(this)
            });

            this.openButton = new Ext.Button({
                text: t("open"),
                iconCls: "pimcore_icon_open",
                handler: function () {
                    window.open(Ext.get("bundle_ecommerce_order_tab1_frame_" + this.id).dom.getAttribute("src"));
                }.bind(this)
            });




            this.panel = new Ext.Panel({
                id: "bundle_ecommerce_order_tab1_" + this.id,
                title: this.title,
                iconCls: this.iconCls,
                border: false,
                layout: "fit",
                closable: false,
                bodyStyle: "-webkit-overflow-scrolling:touch;",
                html: '<iframe src="about:blank" frameborder="0" width="100%" id="bundle_ecommerce_order_tab1_frame_' + this.id + '"></iframe>',
                tbar: [this.reloadButton, this.openButton]
            });

            this.panel.on("resize", this.onLayoutResize.bind(this));
            var that = this;
            this.panel.on("afterrender", function(e){
                that.panel.on("activate", function(e){
                    that.reload();
                });
            });

        }
        return this.panel;

    },

    onLayoutResize: function (el, width, height, rWidth, rHeight) {
        this.setLayoutFrameDimensions(width, height);
    },

    setLayoutFrameDimensions: function (width, height) {
        Ext.get("bundle_ecommerce_order_tab1_frame_" + this.id).setStyle({
            height: (height - 50) + "px"
        });
    },

    reload: function () {
        try {
            Ext.get("bundle_ecommerce_order_tab1_frame_" + this.id).dom.src = this.src;
        }
        catch (e) {
            console.log(e);
        }
    }

});
