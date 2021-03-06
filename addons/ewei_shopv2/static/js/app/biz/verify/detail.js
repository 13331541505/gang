define(["core", "tpl"],
function(f, e, i) {
    var r = {
        params: {},
        init: function() {
            var e = $(".verify-container"),
            i = e.data("verifytype"),
            n = e.data("orderid");
            2 == i && (0 < $(".verify-checkbox:checked").length ? $(".order-verify").find("span").html("确认使用(" + $(".verify-checkbox:checked").length + ")") : $(".order-verify").find("span").html("全部使用")),
            e.find(".verify-cell").each(function() {
                var e = $(this),
                i = e.data("verifycode");
                e.find(".verify-checkbox").unbind("click").click(function() {
                    f.json("verify/select", {
                        id: n,
                        verifycode: i
                    },
                    function(e) {
                        1 == e.status ? setTimeout(function() {
                            $(".verify-checkbox:checked").length <= 0 ? $(".order-verify").find("span").html("全部使用") : $(".order-verify").find("span").html("确认使用(" + $(".verify-checkbox:checked").length + ")")
                        },
                        0) : FoxUI.confirm("发生错误，请刷新重试",
                        function() {})
                    },
                    !0, !0)
                })
            }),
            $(".fui-number").numbers({
                minToast: "最少核销{min}次",
                maxToast: "最多核销{max}次"
            }),
            $(".order-verify").click(function() {
                r.verify($(this))
            })
        },
        verify: function(e) {
            var i = "",
            n = e.data("verifytype"),
            r = e.data("orderid"),
            t = parseInt($(".shownum").val()),
            c = "";
            if (0 == n) i = "确认核销吗?";
            else if (1 == n) {
                if (t <= 0) return void FoxUI.toast.show("最少核销一次");
                i = "确认核销 <span class='text-danger'>" + t + "</span> 次吗?"
            } else 2 == n && (c = $(".verify-cell").data("verifycode"), i = $(".verify-checkbox:checked").length <= 0 ? "确认核销所有消费码吗?": "确认核销选择的消费码吗?");
            FoxUI.confirm(i,
            function() {
                f.json("verify/complete", {
                    id: r,
                    times: t,
                    verifycode: c
                },
                function(e) {
                    0 != e.status ? location.href = f.getUrl("verify/success", {
                        id: r,
                        times: t
                    }) : FoxUI.toast.show(e.result.message)
                })
            })
        }
    };
    return r
});