define(["core", "tpl"],


function(i, t) {





    var n = {
        page: 1,
        keyword: "",
        cateid: 0,
        init: function(t) {
            n.keyword = t.keyword ? t.keyword: "",
            n.cateid = t.cateid ? t.cateid: 0,
            n.page = 1,
            n.lat = "",
            n.lng = "",
            n.range = 2e3,
            (n.sorttype = 0) < n.cateid && $(".sortmenu_cate ul li").each(function() {
                $(this).attr("cateid") == n.cateid && $("#sortmenu_cate_text").html($(this).attr("text"))
            }),
            $(".sortMenu > li").off("click").on("click",
            function() {
                var t = $(this).attr("data-class");
                "none" == $("." + t).css("display") ? ($(".sortMenu > div").hide(), $("." + t).show(), $(".sort-mask").show()) : ($("." + t).hide(), $(".sort-mask").hide())
            }),
            $(".sort-mask").off("click").on("click",
            function() {
                $(this).hide(),
                $(".sortMenu > div").hide()
            }),
            $(".sortmenu_rule ul li").click(function() {
                n.range = $(this).attr("range");
                var t = $(this).attr("text");
                $("#sortmenu_rule_text").html(t),
                $(".sortmenu_rule").hide(),
                n.page = 1,
                $(".container").empty(),
                $(".sort-mask").hide(),
                $(".sortMenu > div").hide(),
                n.getList()
            }),
            $(".sortmenu_cate ul li").click(function() {
                n.cateid = $(this).attr("cateid");
                var t = $(this).attr("text");
                $("#sortmenu_cate_text").html(t),
                $(".sortmenu_cate").hide(),
                n.page = 1,
                $(".container").empty(),
                $(".sort-mask").hide(),
                $(".sortMenu > div").hide(),
                n.getList()
            }),
            $(".sortmenu_sort ul li").click(function() {
                n.sorttype = $(this).attr("sorttype");
                var t = $(this).attr("text");
                $("#sortmenu_sort_text").html(t),
                $(".sortmenu_sort").hide(),
                n.page = 1,
                $(".container").empty(),
                $(".sort-mask").hide(),
                $(".sortMenu > div").hide(),
                n.getList()
            }),
            $(".fui-content").infinite({
                onLoading: function() {
                    1 != n.page && n.getList()
                }
            }),
            1 == n.page && n.getList()
        },
        getList: function() {
            n.getCookie("lat"),
            n.getCookie("lng");
            var e = new AMap.Map("amap-container");
            window.modal = n,
            e.plugin("AMap.Geolocation",
            function() {
                var t = new AMap.Geolocation({
                    enableHighAccuracy: !0,
                    timeout: 5e3,
                    maximumAge: 0
                });
                e.addControl(t),
                t.getCurrentPosition(function(t, e) {
                    if ("complete" == t) n.setCookie("lat", e.position.lat, .1),
                    n.setCookie("lng", e.position.lng, .1),
                    n.lat = e.position.lat,
                    n.lng = e.position.lng,
                    n.getMerch();
                    else {
                        var i = new BMap.Geolocation;
                        window.modal = n,
                        i.getCurrentPosition(function(t) {
                            this.getStatus() == BMAP_STATUS_SUCCESS ? (n.setCookie("lat", t.point.lat, .1), n.setCookie("lng", t.point.lng, .1), n.lat = t.point.lat, n.lng = t.point.lng, n.getMerch()) : FoxUI.toast.show("??????????????????!")
                        },
                        {
                            enableHighAccuracy: !0
                        })
                    }
                })
            })
        },
        getMerch: function() {
            i.json("merch/list/ajaxmerchuser", {
                page: n.page,
                keyword: n.keyword,
                cateid: n.cateid,
                lat: n.lat,
                lng: n.lng,
                range: n.range,
                sorttype: n.sorttype
            },
            function(t) {
                var e = t.result;
                e.total <= 0 ? ($(".content-empty").show(), $(".fui-content").infinite("stop")) : ($(".content-empty").hide(), $(".container").show(), $(".fui-content").infinite("init"), (e.list.length <= 0 || e.list.length < e.pagesize) && $(".fui-content").infinite("stop")),
                n.page++,
                i.tpl(".container", "tpl_merch_list_user", e, 2 < n.page)
            },
            !0, !0)
        },
        getCookie: function(t) {
            for (var e = t + "=",
            i = document.cookie.split(";"), n = 0; n < i.length; n++) {
                for (var o = i[n];
                " " == o.charAt(0);) o = o.substring(1);
                if ( - 1 != o.indexOf(e)) return o.substring(e.length, o.length)
            }
            return ""
        },
        setCookie: function(t, e, i) {
            var n = t + "=" + escape(e);
            if (0 < i) {
                var o = new Date;
                o.setTime(o.getTime() + 3600 * i * 1e3),
                n = n + "; expires=" + o.toGMTString()
            }
            document.cookie = n
        },
        delCookie: function(t) {
            var e = new Date;
            e.setTime(e.getTime() - 1e4),
            document.cookie = t + "=v; expires=" + e.toGMTString()
        }
    };
    return n
});