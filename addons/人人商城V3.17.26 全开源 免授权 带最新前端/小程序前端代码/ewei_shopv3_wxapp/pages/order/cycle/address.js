var t = getApp(), a = t.requirejs("core"), e = t.requirejs("foxui"), i = t.requirejs("jquery");

Page({
    data: {
        id: null,
        posting: !1,
        subtext: "保存地址",
        detail: {
            realname: "",
            mobile: "",
            areas: "",
            street: "",
            address: ""
        },
        showPicker: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        street: [],
        streetIndex: 0,
        noArea: !1,
        cycelid: ""
    },
    onLoad: function(e) {
        this.setData({
            id: Number(e.orderid),
            cycelid: Number(e.cycelid),
            applyid: Number(e.applyid)
        }), t.url(e), this.getDetail(), e.id || wx.setNavigationBarTitle({
            title: "添加收货地址"
        }), this.setData({
            areas: t.getCache("cacheset").areas,
            type: e.type
        });
    },
    getDetail: function() {
        var s = this, t = s.data.id;
        a.get("order/address", {
            id: t,
            applyid: s.data.applyid,
            cycelid: s.data.cycelid
        }, function(t) {
            var e = {
                openstreet: t.openstreet,
                show: !0
            };
            if (!i.isEmptyObject(t.detail)) {
                wx.setNavigationBarTitle({
                    title: "编辑收货地址"
                });
                var a = t.detail.province + " " + t.detail.city + " " + t.detail.area, r = s.getIndex(a, s.data.areas);
                e.pval = r, e.pvalOld = r, e.detail = t.detail;
            }
            s.setData(e), t.openstreet && r && s.getStreet(s.data.areas, r);
        });
    },
    submit: function() {
        var i = this, t = i.data.detail;
        i.data.posting || ("" != t.realname && t.realname ? "" != t.mobile && t.mobile ? "" != t.city && t.city ? !(0 < i.data.street.length) || "" != t.street && t.street ? "" != t.address && t.address ? t.datavalue ? (t.orderid = i.data.id, 
        t.cycelid = i.data.cycelid, i.setData({
            posting: !0
        }), a.post("order/addressSubmit", t, function(t) {
            if (0 != t.error) return i.setData({
                posting: !1
            }), void e.toast(i, t.message);
            i.setData({
                subtext: "提交成功"
            }), a.toast("提交成功");
        })) : e.toast(i, "地址数据出错，请重新选择") : e.toast(i, "请填写详细地址") : e.toast(i, "请选择所在街道") : e.toast(i, "请选择所在地区") : e.toast(i, "请填写联系电话") : e.toast(i, "请填写收件人"));
    },
    onChange: function(t) {
        var e = this.data.detail, a = t.currentTarget.dataset.type, r = i.trim(t.detail.value);
        "street" == a && (e.streetdatavalue = this.data.street[r].code, r = this.data.street[r].name), 
        e[a] = r, this.setData({
            detail: e
        });
    },
    getStreet: function(t, e) {
        if (t && e) {
            var r = this;
            if (r.data.detail.province && r.data.detail.city && this.data.openstreet) {
                var i = t[e[0]].city[e[1]].code, s = t[e[0]].city[e[1]].area[e[2]].code;
                a.get("getstreet", {
                    city: i,
                    area: s
                }, function(t) {
                    var e = t.street, a = {
                        street: e
                    };
                    if (e && r.data.detail.streetdatavalue) for (var i in e) if (e[i].code == r.data.detail.streetdatavalue) {
                        a.streetIndex = i, r.setData({
                            "detail.street": e[i].name
                        });
                        break;
                    }
                    r.setData(a);
                });
            }
        }
    },
    selectArea: function(t) {
        var e = t.currentTarget.dataset.area, a = this.getIndex(e, this.data.areas);
        this.setData({
            pval: a,
            pvalOld: a,
            showPicker: !0
        });
    },
    bindChange: function(t) {
        var e = this.data.pvalOld, a = t.detail.value;
        e[0] != a[0] && (a[1] = 0), e[1] != a[1] && (a[2] = 0), this.setData({
            pval: a,
            pvalOld: a
        });
    },
    onCancel: function(t) {
        this.setData({
            showPicker: !1
        });
    },
    onConfirm: function(t) {
        var e = this.data.pval, a = this.data.areas, i = this.data.detail;
        i.province = a[e[0]].name, i.city = a[e[0]].city[e[1]].name, i.datavalue = a[e[0]].code + " " + a[e[0]].city[e[1]].code, 
        a[e[0]].city[e[1]].area && 0 < a[e[0]].city[e[1]].area.length ? (i.area = a[e[0]].city[e[1]].area[e[2]].name, 
        i.datavalue += " " + a[e[0]].city[e[1]].area[e[2]].code, this.getStreet(a, e)) : i.area = "", 
        i.street = "", this.setData({
            detail: i,
            streetIndex: 0,
            showPicker: !1
        });
    },
    getIndex: function(t, e) {
        if ("" == i.trim(t) || !i.isArray(e)) return [ 0, 0, 0 ];
        var a = t.split(" "), r = [ 0, 0, 0 ];
        for (var s in e) if (e[s].name == a[0]) {
            for (var d in r[0] = Number(s), e[s].city) if (e[s].city[d].name == a[1]) {
                for (var n in r[1] = Number(d), e[s].city[d].area) if (e[s].city[d].area[n].name == a[2]) {
                    r[2] = Number(n);
                    break;
                }
                break;
            }
            break;
        }
        return r;
    },
    updateAll: function(t) {}
});