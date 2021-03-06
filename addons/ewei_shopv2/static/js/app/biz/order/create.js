define(["core", "tpl", "biz/plugin/diyform", "biz/order/invoice"],
function(b, e, o, t) {
	var y = {
		params: {
			orderid: 0,
			goods: [],
			coupon_goods: [],
			merchs: [],
			iscarry: 0,
			isverify: 0,
			isvirtual: 0,
			isonlyverifygoods: 0,
			dispatch_price: 0,
			deductenough_enough: 0,
			merch_deductenough_enough: 0,
			deductenough_money: 0,
			merch_deductenough_money: 0,
			addressid: 0,
			contype: 0,
			couponid: 0,
			card_id: 0,
			card_price: 0,
			wxid: 0,
			wxcardid: 0,
			wxcode: "",
			isnodispatch: 0,
			nodispatch: "",
			packageid: 0,
			card_packageid: 0,
			new_area: "",
			address_street: "",
			discountprice: 0,
			isdiscountprice: 0,
			lotterydiscountprice: 0,
			gift_price: 0,
			giftid: 0,
			show_card: !1,
			city_express_state: !1
		},
		invoice_info: {},
		init: function(e, t) {
			var i = y.getCookie("company"),
			r = y.getCookie("entity"),
			a = decodeURIComponent(y.getCookie("number")),
			d = decodeURIComponent(y.getCookie("title"));
			if (t && t.title && (y.invoice_info = t), (a || d) && (y.invoice_info = {
				company: "true" === i,
				entity: "true" === r,
				number: a,
				title: d
			}), d) {
				var o = "[" + (1 == y.invoice_info.entity ? "纸质": "电子") + "] ";
				o += y.invoice_info.title,
				o += " （" + (1 == y.invoice_info.company ? "单位": "个人") + (y.invoice_info.number ? ": " + y.invoice_info.number: "") + "）",
				$("#invoicename").val(o)
			}
			y.params = $.extend(y.params, e || {}),
			y.params.couponid = 0,
			$("#coupondiv").find(".fui-cell-label").html("优惠券"),
			$("#coupondiv").find(".fui-cell-info").html("");
			var c = b.getNumber($(".discountprice").val()),
			s = b.getNumber($(".isdiscountprice").val());
			0 < c && $(".discount").show(),
			0 < s && $(".isdiscount").show(),
			y.params.city_express_state ? ($(".fui-cell-group.city_express.external").show(), $("#showdispatchprice div:first-child").text("同城运费")) : ($(".fui-cell-group.city_express.external").hide(), $("#showdispatchprice div:first-child").text("运费"));
			var n = !1;
			if (void 0 !== window.selectedAddressData) n = window.selectedAddressData;
			else if (void 0 !== window.editAddressData)(n = window.editAddressData).address = n.areas.replace(/ /gi, "") + " " + n.address;
			else {
				var u = y.getCookie("id"),
				m = y.getCookie("mobile"),
				l = decodeURIComponent(y.getCookie("realname")),
				p = decodeURIComponent(y.getCookie("addressd"));
				0 < u && (n = {
					id: u,
					mobile: m,
					address: p,
					realname: l
				})
			}
			n && (y.params.addressid = n.id, $("#addressInfo .has-address").show(), $("#addressInfo .no-address").hide(), $("#addressInfo .icon-dingwei").show(), $("#addressInfo .realname").html(n.realname), $("#addressInfo .mobile").html(n.mobile), $("#addressInfo .address").html(n.address), $("#addressInfo a").attr("href", b.getUrl("member/address/selector")), $("#addressInfo a").click(function() {
				window.orderSelectedAddressID = n.id
			}));
			var h = !(document.cookie = "id=0");
			if (void 0 !== window.selectedStoreData) {
				h = window.selectedStoreData,
				y.params.storeid = h.id;
				var g = "#carrierInfo";
				1 == y.params.isforceverifystore && 1 == y.params.isverify && (g = "#forceStoreInfo"),
				$(g + " .storename").html(h.storename),
				$(g + " .realname").html(h.realname),
				$(g + "_mobile").html(h.mobile),
				$(g + " .address").html(h.address),
				$(g).find(".no-address").css("display", "none"),
				$(g).find(".has-address").css("display", "block"),
				$(g).find(".fui-list-media").css("display", "block"),
				$(g).find(".text").css("display", "block"),
				$(g).find(".title").css("display", "block"),
				$(g).find(".subtitle").css("display", "block")
			}
			if (FoxUI.tab({
				container: $("#carrierTab"),
				handlers: {
					tab1: function() {
						$(".exchange-withoutpostage").hide(),
						$(".exchange-withpostage").show(),
						y.params.iscarry = 0,
						$("#addressInfo").show(),
						$("#carrierInfo").hide(),
						$("#memberInfo").hide(),
						$("#showdispatchprice").show(),
						y.caculate()
					},
					tab2: function() {
						y.params.iscarry = 1,
						$(".exchange-withpostage").hide(),
						$(".exchange-withoutpostage").show(),
						$("#addressInfo").hide(),
						$("#carrierInfo").show(),
						$("#memberInfo").show(),
						$("#showdispatchprice").hide(),
						y.caculate()
					}
				}
			}), 0 < (a = $(".fui-number")).length) {
				var f = a.data("maxbuy") || 0,
				_ = a.data("goodsid"),
				v = a.data("minbuy") || 0,
				w = a.data("unit") || "件";
				a.numbers({
					max: f,
					min: v,
					minToast: "{min}" + w + "起售",
					maxToast: "最多购买{max}" + w,
					callback: function(e) {
						$.each(y.params.goods,
						function() {
							if (this.goodsid == _) return this.total = e,
							!1
						}),
						$.each(y.params.coupon_goods,
						function() {
							if (this.goodsid == _) return this.total = e,
							!1
						}),
						y.params.contype = 0,
						y.params.couponid = 0,
						y.params.wxid = 0,
						y.params.wxcardid = "",
						y.params.wxcode = "",
						y.params.couponmerchid = 0,
						$("#coupondiv").find(".fui-cell-label").html("优惠券"),
						$("#coupondiv").find(".fui-cell-info").html(""),
						$("#goodscount").html(e);
						var t = b.getNumber(a.closest(".goods-item").find(".marketprice").html()) * e;
						$(".goodsprice").html(b.number_format(t, 2)),
						y.caculate()
					}
				})
			}
			$("#deductcredit").click(function() {
				y.calcCouponPrice(),
				y.calcCardPrice()
			}),
			$("#deductcredit2").click(function() {
				y.calcCouponPrice(),
				y.calcCardPrice()
			}),
			y.bindCoupon(),
			y.bindCard(),
			$(document).click(function() {
				$("input,select,textarea").each(function() {
					$(this).attr("data-value", $(this).val())
				}),
				$(":checkbox,:radio").each(function() {
					$(this).attr("data-checked", $(this).prop("checked"))
				})
			}),
			$("input,select,textarea").each(function() {
				var e = $(this).attr("data-value") || "";
				"" != e && $(this).val(e)
			}),
			$(":checkbox,:radio").each(function() {
				var e = "true" === $(this).attr("data-checked");
				$(this).prop("checked", e)
			}),
			$(".buybtn").click(function() {
				y.submit(this, e.token)
			}),
			y.caculate(),
			$(".fui-cell-giftclick").click(function() {
				y.giftPicker = new FoxUIModal({
					content: $("#gift-picker-modal").html(),
					extraClass: "picker-modal",
					maskClick: function() {
						y.giftPicker.close()
					}
				}),
				y.giftPicker.container.find(".btn-danger").click(function() {
					y.giftPicker.close()
				}),
				y.giftPicker.show();
				var e = $("#giftid").val();
				$(".gift-item").each(function() {
					$(this).val() == e && $(this).prop("checked", "true")
				}),
				$(".gift-item").on("click",
				function() {
					$.ajax({
						url: b.getUrl("goods/detail/querygift", {
							id: $(this).val()
						}),
						cache: !0,
						success: function(e) {
							0 < (e = window.JSON.parse(e)).status && ($("#giftid").val(e.result.id), $("#gifttitle").text(e.result.title))
						}
					})
				})
			}),
			$(".show-allshop-btn").click(function() {
				$(this).closest(".store-container").addClass("open")
			}),
			y.initaddress(),
			$(".card-list-modal").click(function() {
				$(".card-list-modal").removeClass("in"),
				$(".card-list-group").removeClass("in")
			})
		},
		getCookie: function(e) {
			for (var t = e + "=",
			i = document.cookie.split(";"), r = 0; r < i.length; r++) {
				for (var a = i[r];
				" " == a.charAt(0);) a = a.substring(1);
				if ( - 1 != a.indexOf(t)) return a.substring(t.length, a.length)
			}
			return ""
		},
		giftPicker: function() {
			y.giftPicker = new FoxUIModal({
				content: $("#option-picker-modal").html(),
				extraClass: "picker-modal",
				maskClick: function() {
					y.packagePicker.close()
				}
			})
		},
		bindCard: function() {
			$("#selectCard").unbind("click").click(function() {
				$("#cardloading").show(),
				$("#showdispatchprice div:first-child").text("同城运费"),
				b.json("membercard/query", {
					money: 0,
					type: 0,
					goods: y.params.goods,
					discountprice: y.params.discountprice,
					isdiscountprice: y.params.isdiscountprice
				},
				function(t) {
					$("#cardloading").hide(),
					0 < t.result.cards.length || 0 < t.result.wxcards.length ? ($("#selectCard").show().find(".badge").html(t.result.cards.length).show(), $("#selectCard").find(".text-danger").hide(), require(["../addons/ewei_shopv2/plugin/membercard/static/js/picker.js"],
					function(e) {
						e.show({
							card_id: y.params.card_id,
							cards: t.result.cards,
							onCancel: function() {
								y.params.card_id = 0,
								$("#selectCard").find(".fui-cell-label").html("不使用会员卡"),
								$("#selectCard").find(".fui-cell-info").html(""),
								y.calcCardPrice()
							},
							onCaculate: function() {
								y.params.card_id = 0,
								y.caculate()
							},
							onSelected: function(e) {
								y.params.card_id = e.card_id,
								y.params.card_price = e.card_price,
								$("#selectCard").find(".fui-cell-label").html("已选择"),
								$("#selectCard").find(".fui-cell-info").html(e.card_name),
								$("#selectCard").data(e),
								y.calcCardPrice()
							}
						})
					})) : (FoxUI.toast.show("未找到会员卡!"), y.hideCard())
				},
				!1, !0)
			})
		},
		hideCard: function() {
			$("#selectCard").hide(),
			$("#selectCard").find(".badge").html("0").hide(),
			$("#selectCard").find(".text").show()
		},
		hideCoupon: function() {
			$("#coupondiv").hide(),
			$("#coupondiv").find(".badge").html("0").hide(),
			$("#coupondiv").find(".text").show()
		},
		caculate: function() {
			var e = b.getNumber($(".goodsprice").html()) - b.getNumber($(".taskdiscountprice").val()) - b.getNumber($(".lotterydiscountprice").val()) - b.getNumber($(".discountprice").val()) - b.getNumber($(".isdiscountprice").val()) - b.getNumber($("#taskcut").val());
			0 < $(".shownum").length && (e = b.getNumber($(".marketprice").html()) * parseInt($(".shownum").val())),
			0 == y.params.fromcart && 1 == y.params.goods.length && (y.params.goods[0].total = parseInt($(".shownum").val())),
			void 0 !== window.selectedAddressData && (y.params.addressid = window.selectedAddressData.id),
			b.json("order/create/caculate", {
				totalprice: e,
				addressid: y.params.addressid,
				dispatchid: y.params.dispatchid,
				dflag: y.params.iscarry,
				goods: y.params.goods,
				packageid: y.params.card_packageid,
				liveid: y.params.liveid,
				card_id: y.params.card_id,
				giftid: y.params.giftid,
				goods_dispatch: y.params.goods_dispatch
			},
			function(e) {
				if (1 == e.status) {
					$.each(e.result.goods,
					function(e, i) {
						$.each(y.params.coupon_goods,
						function(e, t) {
							i.goodsid == t.goodsid && (y.params.coupon_goods[e].discounttype = i.discounttype, y.params.coupon_goods[e].discountunitprice = i.discountunitprice, y.params.coupon_goods[e].isdiscountunitprice = i.isdiscountunitprice)
						})
					});
					var t = parseInt($(".shownum").val()),
					i = y.params.goods[0].goodsid + "_" + t + "_isgift";
					if (0 == y.params.fromcart && 1 == e.result.isgift && 0 == y.params.giftid && 1 != y.getCookie(i)) {
						y.params.goods[0].goodsid,
						y.params.goods[0].optionid,
						y.params.giftid,
						y.params.liveid;
						document.cookie = i + "=1"
					} else document.cookie = i + "=-1";
					y.params.iscarry ? $(".dispatchprice").html("0.00") : $(".dispatchprice").html(b.number_format(e.result.price, 2)),
					e.result.taskdiscountprice && $("#taskdiscountprice").val(b.number_format(e.result.taskdiscountprice, 2)),
					e.result.lotterydiscountprice && $("#lotterydiscountprice").val(b.number_format(e.result.lotterydiscountprice, 2)),
					e.result.discountprice && $("#discountprice").val(b.number_format(e.result.discountprice, 2)),
					e.result.buyagain && ($("#buyagain").val(b.number_format(e.result.buyagain, 2)), $("#showbuyagainprice").html(b.number_format(e.result.buyagain, 2)).parents(".fui-cell").show()),
					e.result.isdiscountprice && $("#isdiscountprice").val(b.number_format(e.result.isdiscountprice, 2)),
					e.result.deductcredit && ($("#deductcredit_money").html(b.number_format(e.result.deductmoney, 2)), $("#deductcredit_info").html(e.result.deductcredit), $("#deductcredit").data("credit", e.result.deductcredit), $("#deductcredit").data("money", b.number_format(e.result.deductmoney, 2))),
					e.result.deductcredit2 && ($("#deductcredit2_money").html(e.result.deductcredit2), $("#deductcredit2").data("credit2", e.result.deductcredit2)),
					0 < e.result.include_dispath ? $("#include_dispath").show() : $("#include_dispath").hide(),
					0 < e.result.seckillprice ? ($("#seckillprice").show(), $("#seckillprice_money").html(b.number_format(e.result.seckillprice, 2))) : ($("#seckillprice").hide(), $("#seckillprice_money").html(0)),
					0 < e.result.couponcount ? ($("#coupondiv").show().find(".badge").html(e.result.couponcount).show(), $("#coupondiv").find(".text").hide()) : (y.params.couponid = 0, $("#coupondiv").hide().find(".badge").html(0).hide()),
					0 < e.result.merch_deductenough_money ? ($("#merch_deductenough").show(), $("#merch_deductenough_money").html(b.number_format(e.result.merch_deductenough_money, 2)), $("#merch_deductenough_enough").html(b.number_format(e.result.merch_deductenough_enough, 2))) : ($("#merch_deductenough").hide(), $("#merch_deductenough_money").html("0.00"), $("#merch_deductenough_enough").html("0.00")),
					0 < e.result.deductenough_money ? ($("#deductenough").show(), $("#deductenough_money").html(b.number_format(e.result.deductenough_money, 2)), $("#deductenough_enoughdeduct").html(b.number_format(e.result.deductenough_money, 2)), $("#deductenough_enough").html(b.number_format(e.result.deductenough_enough, 2))) : ($("#deductenough").hide(), $("#deductenough_money").html("0.00"), $("#deductenough_enoughdeduct").html("0.00"), $("#deductenough_enough").html("0.00")),
					e.result.merchs && (y.params.merchs = e.result.merchs),
					1 == e.result.isnodispatch ? (y.isnodispatch = 1, y.nodispatch = e.result.nodispatch, FoxUI.toast.show(y.nodispatch)) : (y.isnodispatch = 0, y.nodispatch = ""),
					y.params.city_express_state = e.result.city_express_state,
					y.params.city_express_state ? ($(".fui-cell-group.city_express.external").show(), $("#showdispatchprice div:first-child").text("同城运费")) : ($(".fui-cell-group.city_express.external").hide(), $("#showdispatchprice div:first-child").text("运费")),
					0 < y.params.liveid && 0 == y.params.card_id && ($(".goodsprice").html(b.number_format(e.result.realprice - e.result.price, 2)), $(".marketprice").html(b.number_format(e.result.realprice - e.result.price, 2))),
					y.calcCouponPrice(),
					y.calcCardPrice()
				}
			},
			!0, !0)
		},
		totalPrice: function(e) {
			var t = b.getNumber($(".goodsprice").html());
			0 < y.params.packageid || 0 < y.params.card_packageid ? (t = b.getNumber($(".bigprice-packageprice").html()), $("#showpackageprice").show()) : $("#showpackageprice").hide();
			var i = t - b.getNumber($(".showtaskdiscountprice").html()) - b.getNumber($(".showlotterydiscountprice").html()) - b.getNumber($(".showdiscountprice").html()) - b.getNumber($(".showisdiscountprice").html()) - e - b.getNumber($("#buyagain").val()),
			r = b.getNumber($("#taskcut").val()),
			a = b.getNumber($(".dispatchprice").html()),
			d = (b.getNumber($("#deductenough_enough").html()), b.getNumber($("#merch_deductenough_enough").html()), b.getNumber($("#merch_deductenough_money").html())),
			o = b.getNumber($("#deductenough_money").html());
			d = 0;
			0 < $("#merch_deductenough_money").length && "" != $("#merch_deductenough_money").html() && (d = b.getNumber($("#merch_deductenough_money").html()));
			o = 0;
			0 < $("#deductenough_money").length && "" != $("#deductenough_money").html() && (o = b.getNumber($("#deductenough_money").html()));
			0 < y.params.card_packageid && 0 == y.params.card_id && (i -= b.getNumber($(".packageprice").html())),
			i = i - d - o + a - r;
			var c = 0;
			if (0 < $("#deductcredit").length) {
				var s = b.getNumber($("#deductcredit").data("credit"));
				if ($("#deductcredit").prop("checked")) {
					if (c = b.getNumber($("#deductcredit").data("money")), 0 < $("#deductcredit2").length) {
						var n = b.getNumber($("#deductcredit2").data("credit2"));
						if (0 <= i - c) n < (s = i - c) && (s = n),
						$("#deductcredit2_money").html(b.number_format(s, 2))
					}
				} else if (0 < $("#deductcredit2").length) {
					s = b.getNumber($("#deductcredit2").data("credit2"));
					$("#deductcredit2_money").html(b.number_format(s, 2))
				}
			}
			var u = 0;
			0 < $("#deductcredit2").length && $("#deductcredit2").prop("checked") && (u = b.getNumber($("#deductcredit2_money").html()));
			var m = 0;
			if (0 < $("#seckillprice_money").length && "" != $("#seckillprice_money").html() && (m = b.getNumber($("#seckillprice_money").html())), (i = i - c - u - m) <= 0 && (i = 0), 0 < y.params.gift_price && t > parseInt(y.params.gift_price) ? ($(".giftdiv").show(), $("#giftid").val(y.params.giftid)) : ($(".giftdiv").hide(), $("#giftid").val(0)), $(".totalprice").html(b.number_format(i)), (0 < y.params.packageid || 0 < y.params.card_packageid) && $(".total-packageid").html(b.number_format(i)), 0 < $("#deductcredit2").length) n = b.getNumber($("#deductcredit2").data("credit2")),
			b.getNumber($("#coupondeduct_money").html());
			if (0 < $("#deductcredit").length) n = b.getNumber($("#deductcredit").data("credit")),
			b.getNumber($("#coupondeduct_money").html());
			return y.bindCoupon(),
			y.bindCard(),
			i
		},
		calcCouponPrice: function() {
			var e = b.getNumber($(".goodsprice").html()),
			r = 0,
			t = b.getNumber($(".taskdiscountprice").val()),
			i = b.getNumber($("#taskcut").val()),
			a = b.getNumber($(".lotterydiscountprice").val()),
			d = b.getNumber($(".discountprice").val()),
			o = b.getNumber($(".isdiscountprice").val()),
			c = b.getNumber($("#carddeduct_money").html());
			if (0 == y.params.couponid && 0 == y.params.wxid) return $("#coupondeduct_div").hide(),
			$("#coupondeduct_text").html(""),
			$("#coupondeduct_money").html("0"),
			0 < t ? ($(".showtaskdiscountprice").html($(".taskdiscountprice").val()), $(".istaskdiscount").show()) : $(".istaskdiscount").hide(),
			0 < i ? ($(".showtaskcut").html($("#taskcut").val()), $(".taskcut").show()) : $(".istaskdiscount").hide(),
			0 < a ? ($(".showlotterydiscountprice").html($(".lotterydiscountprice").val()), $(".islotterydiscount").show()) : $(".islotterydiscount").hide(),
			0 < d ? ($(".showdiscountprice").html($(".discountprice").val()), $(".discount").show()) : $(".discount").hide(),
			0 < o ? ($(".showisdiscountprice").html($(".isdiscountprice").val()), $(".isdiscount").show()) : $(".isdiscount").hide(),
			0 < c ? $("#carddeduct_div").show() : $("#carddeduct_div").hide(),
			0 < c ? y.totalPrice(c) : y.totalPrice(0);
			b.json("order/create/getcouponprice", {
				goods: y.params.coupon_goods,
				goodsprice: e,
				real_price: y.realPrice(),
				couponid: y.params.couponid,
				contype: y.params.contype,
				wxid: y.params.wxid,
				wxcardid: y.params.wxcardid,
				wxcode: y.params.wxcode,
				discountprice: d,
				isdiscountprice: o
			},
			function(e) {
				if (1 == e.status) {
					$("#coupondeduct_text").html(e.result.coupondeduct_text),
					r = e.result.deductprice;
					var t = e.result.discountprice,
					i = e.result.isdiscountprice;
					0 < t ? ($(".showdiscountprice").html(t), $(".discount").show()) : ($(".showdiscountprice").html(0), $(".discount").hide()),
					0 < i ? ($(".showisdiscountprice").html(i), $(".isdiscount").show()) : ($(".showisdiscountprice").html(0), $(".isdiscount").hide()),
					0 < r ? ($("#coupondeduct_div").show(), $("#coupondeduct_money").html(b.number_format(r, 2))) : ($("#coupondeduct_div").hide(), $("#coupondeduct_text").html(""), $("#coupondeduct_money").html("0"))
				} else 0 < d ? ($(".showdiscountprice").html($(".discountprice").val()), $(".discount").show()) : $(".discount").hide(),
				0 < o ? ($(".showisdiscountprice").html($(".isdiscountprice").val()), $(".isdiscount").show()) : $(".isdiscount").hide(),
				r = 0;
				return 0 < c ? y.totalPrice(c + r) : y.totalPrice(r)
			},
			!0, !0)
		},
		calcCardPrice: function() {
			if (y.params.show_card) {
				var e = b.getNumber($(".goodsprice").html());
				0 < y.params.packageid && (e = b.getNumber($(".bigprice-packageprice").html())),
				$("#carddeduct_div").hide(),
				$("#carddeduct_text").html(""),
				$("#carddeduct_money").html("0");
				var d = 0,
				o = (b.getNumber($(".taskdiscountprice").val()), b.getNumber($("#taskcut").val()), b.getNumber($(".lotterydiscountprice").val()), b.getNumber($(".discountprice").val())),
				c = b.getNumber($(".isdiscountprice").val()),
				s = b.getNumber($("#coupondeduct_money").html()),
				n = (b.getNumber($("#deductenough_enough").html()), b.getNumber($("#merch_deductenough_enough").html())),
				u = "";
				if (0 == y.params.card_id) return 0 < y.params.card_packageid ? $("#showpackageprice").show() : $("#showpackageprice").hide(),
				$("#taskcut").val(y.params.taskcut),
				$(".showtaskcut").html(y.params.taskcut),
				0 < y.params.taskcut && (y.params.discountprice = 0, y.params.isdiscountprice = 0, y.params.deductenough_enough = 0, y.params.merch_deductenough_enough = 0, $("#deductenough_enough").html("0.00"), $("#merch_deductenough_enough").html("0.00"), $("#deductenough_money").html("0.00"), $("#merch_deductenough_money").html("0.00"), $("#deductenough").hide(), $("#merch_deductenough").hide()),
				0 < y.params.lotterydiscountprice && (y.params.discountprice = 0, y.params.isdiscountprice = 0),
				0 < y.params.card_packageid && (y.params.discountprice = 0, y.params.isdiscountprice = 0, $("#showdiscountprice").html("0"), $("#discountprice").attr("value", "0"), $(".discount").hide(), $("#showisdiscountprice").html("0"), $("#isdiscountprice").attr("value", "0"), $(".isdiscount").hide(), $("#deductenough").hide(), $("#deductenough_money").html("0.00"), $("#deductenough_enoughdeduct").html("0.00"), $("#deductenough_enough").html("0.00"), $("#merch_deductenough").hide(), $("#merch_deductenough_money").html("0.00"), $("#merch_deductenough_enough").html("0.00")),
				0 < y.params.liveid && (y.params.discountprice = 0, y.params.isdiscountprice = 0),
				0 < y.params.lotterydiscountprice && $("#lotterydiscountprice").val(y.params.lotterydiscountprice),
				0 < y.params.lotterydiscountprice && $(".showlotterydiscountprice").html(y.params.lotterydiscountprice),
				b.getNumber($(".dispatchprice").html()) <= 0 && (y.params.iscarry ? $(".dispatchprice").html("0.00") : $(".dispatchprice").html(b.number_format(y.params.dispatch_price, 2))),
				0 < y.params.discountprice && ($("#discountprice").attr("value", y.params.discountprice), $(".showdiscountprice").html(y.params.discountprice)),
				0 < y.params.isdiscountprice && ($("#isdiscountprice").attr("value", y.params.isdiscountprice), $(".showisdiscountprice").html(y.params.isdiscountprice)),
				0 < o || 0 < y.params.discountprice ? $(".discount").show() : $(".discount").hide(),
				0 < c || 0 < y.params.isdiscountprice ? $(".isdiscount").show() : $(".isdiscount").hide(),
				y.params.city_express_state ? ($(".fui-cell-group.city_express.external").show(), $("#showdispatchprice div:first-child").text("同城运费")) : ($(".fui-cell-group.city_express.external").hide(), $("#showdispatchprice div:first-child").text("运费")),
				s ? y.totalPrice(s) : y.totalPrice(0);
				b.json("order/create/getcardprice", {
					goods: y.params.goods,
					goodsprice: e,
					card_id: y.params.card_id,
					liveid: y.params.liveid,
					card_price: y.params.card_price,
					deductenough_enough: y.params.deductenough_enough,
					merch_deductenough_enough: y.params.merch_deductenough_enough,
					dispatch_price: y.params.dispatch_price,
					lotterydiscountprice: y.params.lotterydiscountprice,
					taskcut: y.params.taskcut,
					discountprice: y.params.discountprice,
					isdiscountprice: y.params.isdiscountprice,
					goods_dispatch: y.params.goods_dispatch
				},
				function(e) {
					if (1 == e.status) {
						$("#discountprice").attr("value", e.result.discountprice),
						$("#isdiscountprice").attr("value", e.result.isdiscountprice);
						var t = e.result.discountprice,
						i = e.result.isdiscountprice;
						0 < t ? ($(".showdiscountprice").html(t), $(".discount").show()) : ($(".showdiscountprice").html(0), $(".discount").hide()),
						0 < i ? ($(".showisdiscountprice").html(i), $(".isdiscount").show()) : ($(".showisdiscountprice").html(0), $(".isdiscount").hide()),
						$("#carddeduct_text").html(e.result.carddeduct_text),
						d = e.result.carddeductprice,
						u = e.result.cardname,
						$("#selectCard").find(".fui-cell-label").html("已选择"),
						$("#selectCard").find(".fui-cell-info").html(u),
						$(".islotterydiscount").hide();
						var r = e.result.dispatch_price;
						1 == y.params.iscarry && 0 < r && (r = 0),
						$(".dispatchprice").html(b.number_format(r, 2)),
						0 < d && ($("#carddeduct_div").show(), $("#carddeduct_money").html(b.number_format(d, 2))),
						$("#taskcut").val(b.number_format(e.result.taskcut, 2)),
						$(".showtaskcut").html(b.number_format(e.result.taskcut, 2)),
						0 < e.result.taskcut ? $(".taskcut").show() : $(".taskcut").hide(),
						$("#lotterydiscountprice").val(b.number_format(e.result.lotterydiscountprice, 2)),
						$(".showlotterydiscountprice").html(b.number_format(e.result.lotterydiscountprice, 2)),
						e.result.deductcredit && ($("#deductcredit_money").html(b.number_format(e.result.deductmoney, 2)), $("#deductcredit_info").html(e.result.deductcredit), $("#deductcredit").data("credit", e.result.deductcredit), $("#deductcredit").data("money", b.number_format(e.result.deductmoney, 2))),
						e.result.deductcredit2 && ($("#deductcredit2_money").html(e.result.deductcredit2), $("#deductcredit2").data("credit2", e.result.deductcredit2)),
						0 == e.result.dispatch_price && 1 == e.result.shipping ? $("#showdispatchprice div:first-child").html("运费(<span style='color: #ff0000'>会员卡包邮</span>)") : y.params.city_express_state ? ($(".fui-cell-group.city_express.external").show(), $("#showdispatchprice div:first-child").text("同城运费")) : ($(".fui-cell-group.city_express.external").hide(), $("#showdispatchprice div:first-child").text("运费"));
						var a = b.getNumber($(".packageprice").html());
						0 < y.params.card_packageid && 0 < a || a <= 0 ? $("#showpackageprice").hide() : $("#showpackageprice").show(),
						0 < e.result.deductenough_money ? ($("#deductenough").show(), $("#deductenough_money").html(b.number_format(e.result.deductenough_money, 2)), $("#deductenough_enoughdeduct").html(b.number_format(e.result.deductenough_money, 2)), $("#deductenough_enough").html(b.number_format(e.result.deductenough_enough, 2))) : ($("#deductenough").hide(), $("#deductenough_money").html("0.00"), $("#deductenough_enoughdeduct").html("0.00"), $("#deductenough_enough").html("0.00")),
						e.result.totalprice < n && ($("#merch_deductenough").hide(), $("#merch_deductenough_money").html("0.00"), $("#merch_deductenough_enough").html("0.00")),
						0 < y.params.liveid && ($(".goodsprice").html(b.number_format(e.result.goodsprice, 2)), $(".marketprice").html(b.number_format(e.result.goodsprice, 2)))
					} else 0 < o ? ($(".showdiscountprice").html($(".discountprice").val()), $(".discount").show()) : $(".discount").hide(),
					0 < c ? ($(".showisdiscountprice").html($(".isdiscountprice").val()), $(".isdiscount").show()) : $(".isdiscount").hide(),
					d = 0;
					return 0 < y.params.couponid && y.calcCouponPrice(),
					0 < s ? y.totalPrice(d + s) : y.totalPrice(d)
				},
				!0, !0)
			}
		},
		submit: function(e, t) {
			var i = $(e),
			r = parseInt($("#giftid").val());
			if (y.params.mustbind, !i.attr("stop")) {
				if (y.params.iscarry || y.params.isverify || y.params.isvirtual || y.params.isonlyverifygoods) {
					if ($(":input[name=carrier_realname]").isEmpty() && 0 == $(":input[name=carrier_realname]").attr("data-set")) return void FoxUI.toast.show("请填写联系人");
					if ($(":input[name=carrier_mobile]").isEmpty() && 0 == $(":input[name=carrier_mobile]").attr("data-set")) return void FoxUI.toast.show("请填写联系电话");
					if (!$(":input[name=carrier_mobile]").isMobile() && 0 == $(":input[name=carrier_mobile]").attr("data-set")) return void FoxUI.toast.show("联系电话需请填写11位手机号")
				}
				if (y.params.isonlyverifygoods) {
					if (1 == y.params.isforceverifystore && 0 == y.params.storeid) return void FoxUI.toast.show("请选择核销门店")
				} else if (y.params.iscarry || y.params.isverify || y.params.isvirtual) {
					if (y.params.iscarry && 0 == y.params.storeid) return void FoxUI.toast.show("请选择自提点");
					if (1 == y.params.isforceverifystore && 0 == y.params.storeid) return void FoxUI.toast.show("请选择核销门店")
				} else {
					if (0 == y.params.addressid) if (1 == y.isnodispatch) return void FoxUI.toast.show(y.nodispatch)
				}
				var a = "";
				if (y.params.has_fields) if (! (a = o.getData(".diyform-container"))) return;
				0 == y.params.fromcart && 1 == y.params.goods.length && (y.params.goods[0].total = parseInt($(".shownum").val())),
				i.attr("stop", 1);
				var d = {
					orderid: y.params.orderid,
					id: y.params.id,
					goods: y.params.goods,
					card_id: y.params.card_id,
					giftid: r,
					gdid: y.params.gdid,
					liveid: y.params.liveid,
					diydata: a,
					dispatchtype: y.params.iscarry ? 1 : 0,
					fromcart: y.params.fromcart,
					carrierid: y.params.iscarry ? y.params.storeid: 0,
					addressid: y.params.iscarry ? 0 : y.params.addressid,
					carriers: y.params.iscarry || y.params.isvirtual || y.params.isverify ? {
						carrier_realname: $(":input[name=carrier_realname]").val(),
						carrier_mobile: $(":input[name=carrier_mobile]").val(),
						realname: $("#carrierInfo .realname").html(),
						mobile: $("#carrierInfo_mobile").html(),
						storename: $("#carrierInfo .storename").html(),
						address: $("#carrierInfo .address").html()
					}: "",
					remark: $("#remark").val(),
					officcode: $("#officcode").val(),
					deduct: 0 < $("#deductcredit").length && $("#deductcredit").prop("checked") ? 1 : 0,
					deduct2: 0 < $("#deductcredit2").length && $("#deductcredit2").prop("checked") ? 1 : 0,
					contype: y.params.contype,
					couponid: y.params.couponid,
					wxid: y.params.wxid,
					wxcardid: y.params.wxcardid,
					wxcode: y.params.wxcode,
					invoicename: $("#invoicename").val(),
					submit: !0,
					real_price: y.realPrice(),
					token: t,
					packageid: y.params.card_packageid,
					fromquick: y.params.fromquick,
					goods_dispatch: y.params.goods_dispatch
				};
				y.params.isverify && y.params.isforceverifystore && (d.carrierid = y.params.storeid),
				FoxUI.loader.show("mini"),
				b.json("order/create/submit", d,
				function(e) {
					if (i.removeAttr("stop", 1), 0 == e.status) return FoxUI.loader.hide(),
					void FoxUI.toast.show(e.result.message);
					if ( - 1 == e.status) return FoxUI.loader.hide(),
					void FoxUI.alert(e.result.message);
					if (3 == e.status) return FoxUI.loader.hide(),
					y.endtime = e.result.endtime || 0,
					y.imgcode = e.result.imgcode || 0,
					void require(["biz/member/account"],
					function(e) {
						e.initQuick({
							action: "bind",
							backurl: btoa(location.href),
							endtime: y.endtime,
							imgcode: y.imgcode,
							success: function() {
								var e = y.params;
								e.refresh = !0,
								y.open(e)
							}
						})
					});
					document.cookie = "number=",
					document.cookie = "title=";
					var t = b.getUrl("order/pay", {
						id: e.result.orderid
					});
					b.options && b.options.siteUrl && (t = b.options.siteUrl + "app" + t.substr(1)),
					location.href = t
				},
				!1, !0)
			}
		},
		initaddress: function(e) {
			var t = ["foxui.picker"];
			y.params.new_area && (t = ["foxui.picker", "foxui.citydatanew"]),
			require(t,
			function() {
				if ($("#areas").cityPicker({
					title: "请选择所在城市",
					new_area: y.params.new_area,
					address_street: y.params.address_street,
					onClose: function(e) {
						var t = $("#areas").attr("data-value"),
						i = t.split(" ");
						if (y.params.new_area && $("#areas").attr("data-datavalue", t), y.params.new_area && y.params.address_street) {
							var r = i[1],
							a = i[2];
							r += "",
							a += "";
							var d = y.loadStreetData(r, a),
							o = $('<input type="text" id="street"  name="street" data-value="" value="" placeholder="所在街道"  class="fui-input" readonly=""/>'),
							c = $("#street").closest(".fui-cell-info");
							$("#street").remove(),
							c.append(o),
							o.cityPicker({
								title: "请选择所在街道",
								street: 1,
								data: d,
								onClose: function(e) {
									var t = $("#street").attr("data-value");
									$("#street").attr("data-datavalue", t)
								}
							})
						}
					}
				}), y.params.new_area && y.params.address_street) {
					var e = $("#areas").attr("data-value");
					if (e) {
						var t = e.split(" "),
						i = t[1],
						r = t[2],
						a = y.loadStreetData(i, r);
						$("#street").cityPicker({
							title: "请选择所在街道",
							street: 1,
							data: a
						})
					}
				}
			}),
			$(document).on("click", "#btn-submit",
			function() {
				if (!$(this).attr("submit")) if ($("#realname").isEmpty()) FoxUI.toast.show("请填写收件人");
				else {
					var e = /(境外地区)+/.test($("#areas").val()),
					t = /(台湾)+/.test($("#areas").val()),
					i = /(澳门)+/.test($("#areas").val()),
					r = /(香港)+/.test($("#areas").val());
					if (e || t || i || r) {
						if ($("#mobile").isEmpty()) return void FoxUI.toast.show("请填写手机号码")
					} else if (!$("#mobile").isMobile()) return void FoxUI.toast.show("请填写正确手机号码");
					$("#areas").isEmpty() ? FoxUI.toast.show("请填写所在地区") : $("#address").isEmpty() ? FoxUI.toast.show("请填写详细地址") : ($("#btn-submit").html("正在处理...").attr("submit", 1), window.editAddressData = {
						realname: $("#realname").val(),
						mobile: $("#mobile").val(),
						address: $("#address").val(),
						areas: $("#areas").val(),
						street: $("#street").val(),
						streetdatavalue: $("#street").attr("data-datavalue"),
						datavalue: $("#areas").attr("data-datavalue"),
						isdefault: $("#isdefault").is(":checked") ? 1 : 0
					},
					b.json("member/address/submit", {
						id: $("#addressid").val(),
						addressdata: window.editAddressData
					},
					function(e) {
						$("#btn-submit").html("保存地址").removeAttr("submit"),
						window.editAddressData.id = e.result.addressid,
						1 == e.status ? (FoxUI.toast.show("保存成功!"), $("#addaddress").css("display", "none"), window.location.reload()) : FoxUI.toast.show(e.result.message)
					},
					!0, !0))
				}
			})
		},
		loadStreetData: function(e, t) {
			var i = "../addons/ewei_shopv2/static/js/dist/area/list/" + e.substring(0, 2) + "/" + e + ".xml",
			r = y.loadXmlFile(i).childNodes[0].getElementsByTagName("county"),
			a = [];
			if (0 < r.length) for (var d = 0; d < r.length; d++) {
				var o = r[d];
				if (o.getAttribute("code") == t) for (var c = o.getElementsByTagName("street"), s = 0; s < c.length; s++) {
					var n = c[s];
					a.push({
						text: n.getAttribute("name"),
						value: n.getAttribute("code"),
						children: []
					})
				}
			}
			return a
		},
		bindCoupon: function() {
			$("#coupondiv").unbind("click").click(function() {
				$("#coupondiv").attr("is_open") || ($("#coupondiv").attr("is_open", !0), $("#couponloading").show(), b.json("sale/coupon/util/query", {
					money: 0,
					type: 0,
					merchs: y.params.merchs,
					goods: y.params.goods
				},
				function(t) {
					$("#couponloading").hide(),
					0 < t.result.coupons.length || 0 < t.result.wxcards.length ? ($("#coupondiv").show().find(".badge").html(t.result.coupons.length + t.result.wxcards.length).show(), $("#coupondiv").find(".text").hide(), require(["biz/sale/coupon/picker"],
					function(e) {
						e.show({
							couponid: y.params.couponid,
							coupons: t.result.coupons,
							wxcards: t.result.wxcards,
							onClose: function() {
								$("#coupondiv").removeAttr("is_open")
							},
							onCancel: function() {
								y.params.contype = 0,
								y.params.couponid = 0,
								y.params.wxid = 0,
								y.params.wxcardid = "",
								y.params.wxcode = "",
								y.params.couponmerchid = 0,
								$("#coupondiv").find(".fui-cell-label").html("优惠券"),
								$("#coupondiv").find(".fui-cell-info").html(""),
								y.calcCouponPrice()
							},
							onSelected: function(e) {
								y.params.contype = e.contype,
								1 == y.params.contype ? (y.params.couponid = 0, y.params.wxid = e.wxid, y.params.wxcardid = e.wxcardid, y.params.wxcode = e.wxcode, y.params.couponmerchid = e.merchid, $("#coupondiv").find(".fui-cell-label").html("已选择"), $("#coupondiv").find(".fui-cell-info").html(e.couponname), $("#coupondiv").data(e)) : 2 == y.params.contype ? (y.params.couponid = e.couponid, y.params.wxid = 0, y.params.wxcardid = "", y.params.wxcode = "", y.params.couponmerchid = e.merchid, $("#coupondiv").find(".fui-cell-label").html("已选择"), $("#coupondiv").find(".fui-cell-info").html(e.couponname), $("#coupondiv").data(e)) : (y.params.contype = 0, y.params.couponid = 0, y.params.wxid = 0, y.params.wxcardid = "", y.params.wxcode = "", y.params.couponmerchid = 0, $("#coupondiv").find(".fui-cell-label").html("优惠券"), $("#coupondiv").find(".fui-cell-info").html("")),
								y.calcCouponPrice()
							}
						})
					})) : (FoxUI.toast.show("未找到优惠券!"), y.hideCoupon())
				},
				!1, !0))
			})
		},
		hideCoupon: function() {
			$("#coupondiv").hide(),
			$("#coupondiv").find(".badge").html("0").hide(),
			$("#coupondiv").find(".text").show(),
			$("#coupondiv").removeAttr("is_open")
		},
		loadXmlFile: function(e) {
			var t = null;
			if (window.ActiveXObject)(t = new ActiveXObject("Microsoft.XMLDOM")).async = !1,
			t.load(e) || t.loadXML(e);
			else if (document.implementation && document.implementation.createDocument) {
				var i = new window.XMLHttpRequest;
				i.open("GET", e, !1),
				i.send(null),
				t = i.responseXML
			} else t = null;
			return t
		}
	};
	return $(document).on("click", "#invoicename",
	function() {
		var e = $(this).data("type");
		t.open(y.invoice_info,
		function(e) {
			y.invoice_info = e;
			var t = "[" + (1 == y.invoice_info.entity ? "纸质": "电子") + "] ";
			t += y.invoice_info.title,
			t += " （" + (1 == y.invoice_info.company ? "单位": "个人") + (y.invoice_info.number ? ": " + y.invoice_info.number: "") + "）",
			$("#invoicename").val(t)
		},
		e)
	}),
	y.realPrice = function() {
		var e = b.getNumber($(".goodsprice").html()) - b.getNumber($(".showtaskdiscountprice").html()) - b.getNumber($(".showlotterydiscountprice").html()) - b.getNumber($(".showdiscountprice").html()) - b.getNumber($(".showisdiscountprice").html()) - b.getNumber($("#buyagain").val()),
		t = b.getNumber($("#taskcut").val()),
		i = (b.getNumber($("#deductenough_enough").html()), b.getNumber($("#merch_deductenough_enough").html()), b.getNumber($("#merch_deductenough_money").html())),
		r = b.getNumber($("#deductenough_money").html());
		i = 0;
		0 < $("#merch_deductenough_money").length && "" != $("#merch_deductenough_money").html() && (i = b.getNumber($("#merch_deductenough_money").html()));
		r = 0;
		0 < $("#deductenough_money").length && "" != $("#deductenough_money").html() && (r = b.getNumber($("#deductenough_money").html()));
		0 < y.params.card_packageid && 0 == y.params.card_id && (e -= b.getNumber($(".packageprice").html()));
		y.params.show_card && (e -= b.getNumber($("#carddeduct_money").html())),
		e = e - i - r - t;
		var a = 0;
		return 0 < $("#seckillprice_money").length && "" != $("#seckillprice_money").html() && (a = b.getNumber($("#seckillprice_money").html())),
		(e -= a) <= 0 && (e = 0),
		e
	},
	y
});