define(["core", "tpl"],
function(i, e) {
    var n = {
        params: {},
        init: function(e) {
            n.params = $.extend({
                orderid: 0,
                wechat: {
                    success: !1
                },
                cash: {
                    success: !1
                },
                alipay: {
                    success: !1
                }
            },
            e || {}),
            $(".pay-btn").unbind("click").click(function() {
                var r = $(this);
                i.json("order/pay/check", {
                    id: n.params.orderid
                },
                function(e) {
                    1 == e.status ? n.pay(r) : FoxUI.toast.show(e.result.message)
                },
                !1, !0)
            }),
            1 == n.params.wechat.jie && $('.pay-btn[data-type="wechat"]').click()
        },
        pay: function(e) {
            var r = e.data("type") || "";
            if ("" != r && !e.attr("stop")) if (e.attr("stop", 1), "wechat" == r) {
                if (i.ish5app()) return void appPay("wechat", null, null, !0);
                n.payWechat(e)
            } else if ("alipay" == r) {
                if (i.ish5app()) return void appPay("alipay", null, null, !0);
                n.payAlipay(e)
            } else if ("credit" == r) FoxUI.confirm("确认要支付吗?", "提醒",
            function() {
                n.complete(e, r)
            },
            function() {
                e.removeAttr("stop")
            });
            else {
                if ("peerpay" == r) return void(location.href = i.getUrl("order/pay/peerpay", {
                    id: n.params.orderid
                }));
                n.complete(e, r)
            }
        },
        payWechat: function(r) {
            var e = n.params.wechat;
            if (e.success) {
                if (e.weixin) {
                    function a() {
                        WeixinJSBridge.invoke("getBrandWCPayRequest", {
                            appId: e.appid ? e.appid: e.appId,
                            timeStamp: e.timeStamp,
                            nonceStr: e.nonceStr,
                            package: e.package,
                            signType: e.signType,
                            paySign: e.paySign
                        },
                        function(e) {
                            "get_brand_wcpay_request:ok" == e.err_msg ? n.complete(r, "wechat") : "get_brand_wcpay_request:cancel" == e.err_msg ? FoxUI.toast.show("取消支付") : FoxUI.toast.show(e.err_msg),
                            r.removeAttr("stop")
                        })
                    }
                    "undefined" == typeof WeixinJSBridge ? document.addEventListener ? document.addEventListener("WeixinJSBridgeReady", a, !1) : document.attachEvent && (document.attachEvent("WeixinJSBridgeReady", a), document.attachEvent("onWeixinJSBridgeReady", a)) : a()
                } ! e.weixin_jie && 1 != e.jie || n.payWechatJie(r, e)
            }
        },
        payWechatJie: function(e, r) {
            var a = i.getUrl("index/qr", {
                url: r.code_url
            });
            $("#qrmoney").text(n.params.money),
            $(".order-weixinpay-hidden").show(),
            $("#btnWeixinJieCancel").unbind("click").click(function() {
                e.removeAttr("stop"),
                clearInterval(t),
                $(".order-weixinpay-hidden").hide()
            });
            var t = setInterval(function() {
                $.getJSON(i.getUrl("order/pay/orderstatus"), {
                    id: n.params.orderid
                },
                function(e) {
                    1 <= e.status && (clearInterval(t), location.href = i.getUrl("order/pay/success", {
                        id: n.params.orderid
                    }))
                })
            },
            1e3);
            $(".verify-pop").find(".close").unbind("click").click(function() {
                $(".order-weixinpay-hidden").hide(),
                e.removeAttr("stop"),
                clearInterval(t)
            }),
            $(".verify-pop").find(".qrimg").attr("src", a).show()
        },
        payAlipay: function(e) {
            var r = n.params.alipay;
            r.success && (location.href = i.getUrl("order/pay_alipay", {
                orderid: n.params.orderid,
                type: 0,
                url: r.url
            }))
        },
        complete: function(r, e) {
            var a = $("#peerpay").text(),
            t = $("#peerpaymessage").val();
            FoxUI.loader.show("mini"),
            setTimeout(function() {
                i.json("order/pay/complete", {
                    id: n.params.orderid,
                    ordersn: n.params.ordersn,
                    type: e,
                    peerpay: a,
                    peerpaymessage: t
                },
                function(e) {
                    1 != e.status ? (FoxUI.loader.hide(), r.removeAttr("stop"), FoxUI.confirm("余额不足", "提醒",
                    function() {
                        // location.href = i.getUrl("member/recharge", {
                        //     id: n.params.orderid
                        // })
                    },
                    function() {
                        r.removeAttr("stop")
                    })) : location.href = i.getUrl("order/pay/success", {
                        id: n.params.orderid,
                        result: e.result.result
                    })
                },
                !1, !0)
            },
            1e3)
        }
    };
    return n
});