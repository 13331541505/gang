var t = getApp(), e = t.requirejs("core"), a = t.requirejs("jquery"), r = t.requirejs("biz/selectdate"), i = t.requirejs("foxui");

Page({
    data: {
        status: "0",
        currentDate: "",
        dayList: "",
        currentDayList: "",
        currentObj: "",
        currentDay: "",
        cycelData: {},
        nowDate: "",
        maxday: "",
        cycelbuy_periodic: "",
        period_index: 1,
        cycelid: "",
        orderid: "",
        refundstate: 0
    },
    onLoad: function(e) {
        t.getCache("isIpx") ? this.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : this.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), this.get_list();
    },
    show_cycelbuydate: function() {
        var t = r.getCurrentDayString(this, this.data.nowDate);
        this.setData({
            currentObj: t,
            currentDate: t.getFullYear() + "年" + (t.getMonth() + 1) + "月" + t.getDate() + "日 " + [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ][t.getDay()],
            currentYear: t.getFullYear(),
            currentMonth: t.getMonth() + 1,
            currentDay: t.getDate(),
            initDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            checkedDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            maxday: this.data.maxday,
            cycelbuy_periodic: this.data.cycelbuy_periodic,
            period_index: this.data.period_index
        });
    },
    cycle: function(t) {
        var e = t.currentTarget.dataset.status + 1;
        this.setData({
            status: t.currentTarget.dataset.status,
            cycelid: t.currentTarget.dataset.id,
            period_index: e
        });
    },
    syclecancle: function() {
        this.setData({
            cycledate: !1
        });
    },
    sycleconfirm: function() {
        var r = this, t = r.data.cycelid, a = r.data.checkedDate / 1e3, c = r.data.orderid, d = r.data.isdelay;
        e.get("order/do_deferred", {
            cycelid: t,
            time: a,
            orderid: c,
            is_all: d
        }, function(t) {
            0 == t.error && i.toast(r, "修改成功");
            var e = r.data.list, a = r.data.period_index;
            console.log(r.data), e[a].receipttime = r.data.currentYear + "-" + (r.data.currentMonth < 10 ? "0" : "") + r.data.currentMonth + "-" + (r.data.currentDay < 10 ? "0" : "") + r.data.currentDay, 
            e[a].week = r.data.week, console.log(e[a].receipttime), console.log(r.data.currentYear + "-" + r.data.currentMonth + "-" + r.data.currentDay), 
            r.data.nowDate = r.data.currentYear + (r.data.currentMonth < 10 ? "0" : "") + r.data.currentMonth + (r.data.currentDay < 10 ? "0" : "") + r.data.currentDay, 
            r.setData({
                list: e
            });
        }), this.setData({
            cycledate: !1
        });
    },
    editdate: function(t) {
        var a = this, i = t.currentTarget.dataset.isdelay, c = t.currentTarget.dataset.id;
        e.get("order/getCycelbuyDate", {
            cycelid: c
        }, function(t) {
            a.setData({
                nowDate: t.receipttime
            }), a.show_cycelbuydate(), r.setSchedule(a);
        }), this.setData({
            isdelay: i
        }), this.setData({
            cycledate: !0
        });
    },
    doDay: function(t) {
        r.doDay(t, this);
    },
    selectDay: function(t) {
        r.selectDay(t, this), r.setSchedule(this);
    },
    get_list: function() {
        var i = this;
        e.get("order/cycelbuy_list", i.options, function(r) {
            0 < r.error && 5e4 != list.error && e.toast(list.message, "loading"), 0 == r.notStart && a.each(r.list, function(t, e) {
                1 == e.status ? i.setData({
                    status: t
                }) : i.setData({
                    status: r.period_index
                });
            }), i.setData({
                cycelid: r.list[0].id,
                orderid: r.orderid
            }), i.setData(r);
        });
    },
    confirm_receipt: function(t) {
        var a = this, r = t.currentTarget.dataset.id, c = a.data.orderid;
        e.get("order/confirm_receipt", {
            id: r,
            orderid: c
        }, function(t) {
            0 == t.error && (i.toast(a, "修改成功"), a.onLoad());
        });
    }
});