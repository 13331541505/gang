var t = getApp(), e = t.requirejs("core"), a = t.requirejs("biz/order");

Page({
    data: {
        code: 1,
        tempFilePaths: "",
        delete: "",
        rtypeArr: [ "退款(仅退款不退货)", "退货退款", "换货" ],
        rtypeArrText: [ "退款", "退款", "换货" ],
        rtypeIndex: 1,
        reasonArr: [ "不想要了", "卖家缺货", "拍错了/订单信息错误", "其它" ],
        reasonIndex: 0,
        images: []
    },
    onLoad: function(e) {
        this.setData({
            options: e
        }), t.url(e), this.get_list();
    },
    get_list: function() {
        var r = this;
        e.get("order/refund", r.data.options, function(t) {
            if (r.setData({
                show: !0
            }), 0 == t.error) {
                t.order.status < 2 && (t.rtypeArr = [ "退款(仅退款不退货)" ]);
                var a = [];
                for (var i in t.rtypeArr) a.push(t.rtypeArr[i]);
                t.rtypeArr = a, r.setData(t);
            } else e.toast(t.message, "loading"), setTimeout(function() {
                wx.navigateBack();
            }, 1500);
        });
    },
    submit: function() {
        var t = {
            id: this.data.options.id,
            rtype: this.data.rtypeIndex,
            reason: this.data.reasonArr[this.data.reasonIndex],
            content: this.data.content,
            price: this.data.price,
            images: this.data.images
        };
        e.post("order/refund/submit", t, function(t) {
            0 == t.error ? wx.navigateBack() : e.toast(t.message, "loading");
        }, !0);
    },
    change: function(t) {
        var a = {};
        a[e.data(t).name] = t.detail.value, this.setData(a);
    },
    upload: function(t) {
        var a = this, i = e.data(t), r = i.type, s = a.data.images, n = a.data.imgs, o = i.index;
        "image" == r ? e.upload(function(e) {
            s.push(e.filename), n.push(e.url), a.setData({
                images: s,
                imgs: n
            });
        }) : "image-remove" == r ? (s.splice(o, 1), n.splice(o, 1), a.setData({
            images: s,
            imgs: n
        })) : "image-preview" == r && wx.previewImage({
            current: n[o],
            urls: n
        });
    },
    toggle: function(t) {
        var a = e.pdata(t).id;
        a = 0 == a || void 0 === a ? 1 : 0, this.setData({
            code: a
        });
    },
    edit: function(e) {
        this.setData({
            "order.refundstate": 0
        });
    },
    refundcancel: function(e) {
        a.refundcancel(this.data.options.id, function() {
            wx.navigateBack();
        });
    }
});