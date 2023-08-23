/*here the bootstrap js code*/

$(document).ready(function (){

    var time = $(".ps-countdown");
    time.each(function () {
        var el = $(this),
            value = $(this).data('time');
        var countDownDate = new Date(value).getTime();
        var timeout = setInterval(function () {
            var now = new Date().getTime(),
                distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                seconds = Math.floor((distance % (1000 * 60)) / 1000);
            el.find('.days').html(days);
            el.find('.hours').html(hours);
            el.find('.minutes').html(minutes);
            el.find('.seconds').html(seconds);
            if (distance < 0) {
                clearInterval(timeout);
                el.closest('.ps-section').hide();
            }
        }, 1000);
    });

});
!(function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? e(exports, require("jquery"), require("popper.js")) : "function" == typeof define && define.amd ? define(["exports", "jquery", "popper.js"], e) : e((t.bootstrap = {}), t.jQuery, t.Popper);
})(this, function (t, e, h) {
    "use strict";

    function i(t, e) {
        for (var n = 0; n < e.length; n++) {
            var i = e[n];
            (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
    }

    function s(t, e, n) {
        return e && i(t.prototype, e), n && i(t, n), t;
    }

    function l(r) {
        for (var t = 1; t < arguments.length; t++) {
            var o = null != arguments[t] ? arguments[t] : {},
                e = Object.keys(o);
            "function" == typeof Object.getOwnPropertySymbols && (e = e.concat(Object.getOwnPropertySymbols(o).filter(function (t) {
                return Object.getOwnPropertyDescriptor(o, t).enumerable;
            }))), e.forEach(function (t) {
                var e, n, i;
                (e = r), (i = o[(n = t)]), n in e ? Object.defineProperty(e, n, {
                    value: i,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                }) : (e[n] = i);
            });
        }
        return r;
    }
    (e = e && e.hasOwnProperty("default") ? e.default : e), (h = h && h.hasOwnProperty("default") ? h.default : h);
    var r, n, o, a, c, u, f, d, g, _, m, p, v, y, E, C, T, b, S, I, A, D, w, N, O, k, P, j, H, L, R, x, W, U, q, F, K, M, Q, B, V, Y, z, J, Z, G, $, X, tt, et, nt, it, rt, ot, st, at, lt, ct, ht, ut, ft, dt, gt, _t, mt, pt, vt, yt, Et, Ct, Tt, bt, St, It, At, Dt, wt, Nt, Ot, kt, Pt, jt, Ht, Lt, Rt, xt, Wt, Ut, qt, Ft, Kt, Mt, Qt, Bt, Vt, Yt, zt, Jt, Zt, Gt, $t, Xt, te, ee, ne, ie, re, oe, se, ae, le, ce, he, ue, fe, de, ge, _e, me, pe, ve, ye, Ee, Ce, Te, be, Se, Ie, Ae, De, we, Ne, Oe, ke, Pe, je, He, Le, Re, xe, We, Ue, qe, Fe, Ke, Me, Qe, Be, Ve, Ye, ze, Je, Ze, Ge, $e, Xe, tn, en, nn, rn, on, sn, an, ln, cn, hn, un, fn, dn, gn, _n, mn, pn, vn, yn, En, Cn, Tn, bn, Sn, In, An, Dn, wn, Nn, On, kn, Pn, jn, Hn, Ln, Rn, xn, Wn, Un, qn, Fn = (function (i) {
            var e = "transitionend";

            function t(t) {
                var e = this,
                    n = !1;
                return (i(this).one(l.TRANSITION_END, function () {
                    n = !0;
                }), setTimeout(function () {
                    n || l.triggerTransitionEnd(e);
                }, t), this);
            }
            var l = {
                TRANSITION_END: "bsTransitionEnd",
                getUID: function (t) {
                    for (;
                        (t += ~~(1e6 * Math.random())), document.getElementById(t););
                    return t;
                },
                getSelectorFromElement: function (t) {
                    var e = t.getAttribute("data-target");
                    (e && "#" !== e) || (e = t.getAttribute("href") || "");
                    try {
                        return document.querySelector(e) ? e : null;
                    } catch (t) {
                        return null;
                    }
                },
                getTransitionDurationFromElement: function (t) {
                    if (!t) return 0;
                    var e = i(t).css("transition-duration");
                    return parseFloat(e) ? ((e = e.split(",")[0]), 1e3 * parseFloat(e)) : 0;
                },
                reflow: function (t) {
                    return t.offsetHeight;
                },
                triggerTransitionEnd: function (t) {
                    i(t).trigger(e);
                },
                supportsTransitionEnd: function () {
                    return Boolean(e);
                },
                isElement: function (t) {
                    return (t[0] || t).nodeType;
                },
                typeCheckConfig: function (t, e, n) {
                    for (var i in n)
                        if (Object.prototype.hasOwnProperty.call(n, i)) {
                            var r = n[i],
                                o = e[i],
                                s = o && l.isElement(o) ? "element" : ((a = o), {}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase());
                            if (!new RegExp(r).test(s)) throw new Error(t.toUpperCase() + ': Option "' + i + '" provided type "' + s + '" but expected type "' + r + '".');
                        }
                    var a;
                },
            };
            return ((i.fn.emulateTransitionEnd = t), (i.event.special[l.TRANSITION_END] = {
                bindType: e,
                delegateType: e,
                handle: function (t) {
                    if (i(t.target).is(this)) return t.handleObj.handler.apply(this, arguments);
                },
            }), l);
        })(e),
        Kn = ((n = "alert"), (a = "." + (o = "bs.alert")), (c = (r = e).fn[n]), (u = {
            CLOSE: "close" + a,
            CLOSED: "closed" + a,
            CLICK_DATA_API: "click" + a + ".data-api"
        }), (f = "alert"), (d = "fade"), (g = "show"), (_ = (function () {
            function i(t) {
                this._element = t;
            }
            var t = i.prototype;
            return ((t.close = function (t) {
                var e = this._element;
                t && (e = this._getRootElement(t)), this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e);
            }), (t.dispose = function () {
                r.removeData(this._element, o), (this._element = null);
            }), (t._getRootElement = function (t) {
                var e = Fn.getSelectorFromElement(t),
                    n = !1;
                return e && (n = document.querySelector(e)), n || (n = r(t).closest("." + f)[0]), n;
            }), (t._triggerCloseEvent = function (t) {
                var e = r.Event(u.CLOSE);
                return r(t).trigger(e), e;
            }), (t._removeElement = function (e) {
                var n = this;
                if ((r(e).removeClass(g), r(e).hasClass(d))) {
                    var t = Fn.getTransitionDurationFromElement(e);
                    r(e).one(Fn.TRANSITION_END, function (t) {
                        return n._destroyElement(e, t);
                    }).emulateTransitionEnd(t);
                } else this._destroyElement(e);
            }), (t._destroyElement = function (t) {
                r(t).detach().trigger(u.CLOSED).remove();
            }), (i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = r(this),
                        e = t.data(o);
                    e || ((e = new i(this)), t.data(o, e)), "close" === n && e[n](this);
                });
            }), (i._handleDismiss = function (e) {
                return function (t) {
                    t && t.preventDefault(), e.close(this);
                };
            }), s(i, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, ]), i);
        })()), r(document).on(u.CLICK_DATA_API, '[data-dismiss="alert"]', _._handleDismiss(new _())), (r.fn[n] = _._jQueryInterface), (r.fn[n].Constructor = _), (r.fn[n].noConflict = function () {
            return (r.fn[n] = c), _._jQueryInterface;
        }), _),
        Mn = ((p = "button"), (y = "." + (v = "bs.button")), (E = ".data-api"), (C = (m = e).fn[p]), (T = "active"), (b = "btn"), (I = '[data-toggle^="button"]'), (A = '[data-toggle="buttons"]'), (D = "input"), (w = ".active"), (N = ".btn"), (O = {
            CLICK_DATA_API: "click" + y + E,
            FOCUS_BLUR_DATA_API: (S = "focus") + y + E + " blur" + y + E
        }), (k = (function () {
            function n(t) {
                this._element = t;
            }
            var t = n.prototype;
            return ((t.toggle = function () {
                var t = !0,
                    e = !0,
                    n = m(this._element).closest(A)[0];
                if (n) {
                    var i = this._element.querySelector(D);
                    if (i) {
                        if ("radio" === i.type)
                            if (i.checked && this._element.classList.contains(T)) t = !1;
                            else {
                                var r = n.querySelector(w);
                                r && m(r).removeClass(T);
                            }
                        if (t) {
                            if (i.hasAttribute("disabled") || n.hasAttribute("disabled") || i.classList.contains("disabled") || n.classList.contains("disabled")) return;
                            (i.checked = !this._element.classList.contains(T)), m(i).trigger("change");
                        }
                        i.focus(), (e = !1);
                    }
                }
                e && this._element.setAttribute("aria-pressed", !this._element.classList.contains(T)), t && m(this._element).toggleClass(T);
            }), (t.dispose = function () {
                m.removeData(this._element, v), (this._element = null);
            }), (n._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = m(this).data(v);
                    t || ((t = new n(this)), m(this).data(v, t)), "toggle" === e && t[e]();
                });
            }), s(n, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, ]), n);
        })()), m(document).on(O.CLICK_DATA_API, I, function (t) {
            t.preventDefault();
            var e = t.target;
            m(e).hasClass(b) || (e = m(e).closest(N)), k._jQueryInterface.call(m(e), "toggle");
        }).on(O.FOCUS_BLUR_DATA_API, I, function (t) {
            var e = m(t.target).closest(N)[0];
            m(e).toggleClass(S, /^focus(in)?$/.test(t.type));
        }), (m.fn[p] = k._jQueryInterface), (m.fn[p].Constructor = k), (m.fn[p].noConflict = function () {
            return (m.fn[p] = C), k._jQueryInterface;
        }), k),
        Qn = ((j = "carousel"), (L = "." + (H = "bs.carousel")), (R = ".data-api"), (x = (P = e).fn[j]), (W = {
            interval: 5e3,
            keyboard: !0,
            slide: !1,
            pause: "hover",
            wrap: !0
        }), (U = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean"
        }), (q = "next"), (F = "prev"), (K = "left"), (M = "right"), (Q = {
            SLIDE: "slide" + L,
            SLID: "slid" + L,
            KEYDOWN: "keydown" + L,
            MOUSEENTER: "mouseenter" + L,
            MOUSELEAVE: "mouseleave" + L,
            TOUCHEND: "touchend" + L,
            LOAD_DATA_API: "load" + L + R,
            CLICK_DATA_API: "click" + L + R
        }), (B = "carousel"), (V = "active"), (Y = "slide"), (z = "carousel-item-right"), (J = "carousel-item-left"), (Z = "carousel-item-next"), (G = "carousel-item-prev"), ($ = ".active"), (X = ".active.carousel-item"), (tt = ".carousel-item"), (et = ".carousel-item-next, .carousel-item-prev"), (nt = ".carousel-indicators"), (it = "[data-slide], [data-slide-to]"), (rt = '[data-ride="carousel"]'), (ot = (function () {
            function o(t, e) {
                (this._items = null), (this._interval = null), (this._activeElement = null), (this._isPaused = !1), (this._isSliding = !1), (this.touchTimeout = null), (this._config = this._getConfig(e)), (this._element = P(t)[0]), (this._indicatorsElement = this._element.querySelector(nt)), this._addEventListeners();
            }
            var t = o.prototype;
            return ((t.next = function () {
                this._isSliding || this._slide(q);
            }), (t.nextWhenVisible = function () {
                !document.hidden && P(this._element).is(":visible") && "hidden" !== P(this._element).css("visibility") && this.next();
            }), (t.prev = function () {
                this._isSliding || this._slide(F);
            }), (t.pause = function (t) {
                t || (this._isPaused = !0), this._element.querySelector(et) && (Fn.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), (this._interval = null);
            }), (t.cycle = function (t) {
                t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), (this._interval = null)), this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval));
            }), (t.to = function (t) {
                var e = this;
                this._activeElement = this._element.querySelector(X);
                var n = this._getItemIndex(this._activeElement);
                if (!(t > this._items.length - 1 || t < 0))
                    if (this._isSliding)
                        P(this._element).one(Q.SLID, function () {
                            return e.to(t);
                        });
                    else {
                        if (n === t) return this.pause(), void this.cycle();
                        var i = n < t ? q : F;
                        this._slide(i, this._items[t]);
                    }
            }), (t.dispose = function () {
                P(this._element).off(L), P.removeData(this._element, H), (this._items = null), (this._config = null), (this._element = null), (this._interval = null), (this._isPaused = null), (this._isSliding = null), (this._activeElement = null), (this._indicatorsElement = null);
            }), (t._getConfig = function (t) {
                return (t = l({}, W, t)), Fn.typeCheckConfig(j, t, U), t;
            }), (t._addEventListeners = function () {
                var e = this;
                this._config.keyboard && P(this._element).on(Q.KEYDOWN, function (t) {
                    return e._keydown(t);
                }), "hover" === this._config.pause && (P(this._element).on(Q.MOUSEENTER, function (t) {
                    return e.pause(t);
                }).on(Q.MOUSELEAVE, function (t) {
                    return e.cycle(t);
                }), "ontouchstart" in document.documentElement && P(this._element).on(Q.TOUCHEND, function () {
                    e.pause(), e.touchTimeout && clearTimeout(e.touchTimeout), (e.touchTimeout = setTimeout(function (t) {
                        return e.cycle(t);
                    }, 500 + e._config.interval));
                }));
            }), (t._keydown = function (t) {
                if (!/input|textarea/i.test(t.target.tagName))
                    switch (t.which) {
                        case 37:
                            t.preventDefault(), this.prev();
                            break;
                        case 39:
                            t.preventDefault(), this.next();
                    }
            }), (t._getItemIndex = function (t) {
                return (this._items = t && t.parentNode ? [].slice.call(t.parentNode.querySelectorAll(tt)) : []), this._items.indexOf(t);
            }), (t._getItemByDirection = function (t, e) {
                var n = t === q,
                    i = t === F,
                    r = this._getItemIndex(e),
                    o = this._items.length - 1;
                if (((i && 0 === r) || (n && r === o)) && !this._config.wrap) return e;
                var s = (r + (t === F ? -1 : 1)) % this._items.length;
                return -1 === s ? this._items[this._items.length - 1] : this._items[s];
            }), (t._triggerSlideEvent = function (t, e) {
                var n = this._getItemIndex(t),
                    i = this._getItemIndex(this._element.querySelector(X)),
                    r = P.Event(Q.SLIDE, {
                        relatedTarget: t,
                        direction: e,
                        from: i,
                        to: n
                    });
                return P(this._element).trigger(r), r;
            }), (t._setActiveIndicatorElement = function (t) {
                if (this._indicatorsElement) {
                    var e = [].slice.call(this._indicatorsElement.querySelectorAll($));
                    P(e).removeClass(V);
                    var n = this._indicatorsElement.children[this._getItemIndex(t)];
                    n && P(n).addClass(V);
                }
            }), (t._slide = function (t, e) {
                var n, i, r, o = this,
                    s = this._element.querySelector(X),
                    a = this._getItemIndex(s),
                    l = e || (s && this._getItemByDirection(t, s)),
                    c = this._getItemIndex(l),
                    h = Boolean(this._interval);
                if ((t === q ? ((n = J), (i = Z), (r = K)) : ((n = z), (i = G), (r = M)), l && P(l).hasClass(V))) this._isSliding = !1;
                else if (!this._triggerSlideEvent(l, r).isDefaultPrevented() && s && l) {
                    (this._isSliding = !0), h && this.pause(), this._setActiveIndicatorElement(l);
                    var u = P.Event(Q.SLID, {
                        relatedTarget: l,
                        direction: r,
                        from: a,
                        to: c
                    });
                    if (P(this._element).hasClass(Y)) {
                        P(l).addClass(i), Fn.reflow(l), P(s).addClass(n), P(l).addClass(n);
                        var f = Fn.getTransitionDurationFromElement(s);
                        P(s).one(Fn.TRANSITION_END, function () {
                            P(l).removeClass(n + " " + i).addClass(V), P(s).removeClass(V + " " + i + " " + n), (o._isSliding = !1), setTimeout(function () {
                                return P(o._element).trigger(u);
                            }, 0);
                        }).emulateTransitionEnd(f);
                    } else P(s).removeClass(V), P(l).addClass(V), (this._isSliding = !1), P(this._element).trigger(u);
                    h && this.cycle();
                }
            }), (o._jQueryInterface = function (i) {
                return this.each(function () {
                    var t = P(this).data(H),
                        e = l({}, W, P(this).data());
                    "object" == typeof i && (e = l({}, e, i));
                    var n = "string" == typeof i ? i : e.slide;
                    if ((t || ((t = new o(this, e)), P(this).data(H, t)), "number" == typeof i)) t.to(i);
                    else if ("string" == typeof n) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]();
                    } else e.interval && (t.pause(), t.cycle());
                });
            }), (o._dataApiClickHandler = function (t) {
                var e = Fn.getSelectorFromElement(this);
                if (e) {
                    var n = P(e)[0];
                    if (n && P(n).hasClass(B)) {
                        var i = l({}, P(n).data(), P(this).data()),
                            r = this.getAttribute("data-slide-to");
                        r && (i.interval = !1), o._jQueryInterface.call(P(n), i), r && P(n).data(H).to(r), t.preventDefault();
                    }
                }
            }), s(o, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return W;
                },
            }, ]), o);
        })()), P(document).on(Q.CLICK_DATA_API, it, ot._dataApiClickHandler), P(window).on(Q.LOAD_DATA_API, function () {
            for (var t = [].slice.call(document.querySelectorAll(rt)), e = 0, n = t.length; e < n; e++) {
                var i = P(t[e]);
                ot._jQueryInterface.call(i, i.data());
            }
        }), (P.fn[j] = ot._jQueryInterface), (P.fn[j].Constructor = ot), (P.fn[j].noConflict = function () {
            return (P.fn[j] = x), ot._jQueryInterface;
        }), ot),
        Bn = ((at = "collapse"), (ct = "." + (lt = "bs.collapse")), (ht = (st = e).fn[at]), (ut = {
            toggle: !0,
            parent: ""
        }), (ft = {
            toggle: "boolean",
            parent: "(string|element)"
        }), (dt = {
            SHOW: "show" + ct,
            SHOWN: "shown" + ct,
            HIDE: "hide" + ct,
            HIDDEN: "hidden" + ct,
            CLICK_DATA_API: "click" + ct + ".data-api"
        }), (gt = "show"), (_t = "collapse"), (mt = "collapsing"), (pt = "collapsed"), (vt = "width"), (yt = "height"), (Et = ".show, .collapsing"), (Ct = '[data-toggle="collapse"]'), (Tt = (function () {
            function a(e, t) {
                (this._isTransitioning = !1), (this._element = e), (this._config = this._getConfig(t)), (this._triggerArray = st.makeArray(document.querySelectorAll('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]')));
                for (var n = [].slice.call(document.querySelectorAll(Ct)), i = 0, r = n.length; i < r; i++) {
                    var o = n[i],
                        s = Fn.getSelectorFromElement(o),
                        a = [].slice.call(document.querySelectorAll(s)).filter(function (t) {
                            return t === e;
                        });
                    null !== s && 0 < a.length && ((this._selector = s), this._triggerArray.push(o));
                }
                (this._parent = this._config.parent ? this._getParent() : null), this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
            }
            var t = a.prototype;
            return ((t.toggle = function () {
                st(this._element).hasClass(gt) ? this.hide() : this.show();
            }), (t.show = function () {
                var t, e, n = this;
                if (!this._isTransitioning && !st(this._element).hasClass(gt) && (this._parent && 0 === (t = [].slice.call(this._parent.querySelectorAll(Et)).filter(function (t) {
                    return t.getAttribute("data-parent") === n._config.parent;
                })).length && (t = null), !(t && (e = st(t).not(this._selector).data(lt)) && e._isTransitioning))) {
                    var i = st.Event(dt.SHOW);
                    if ((st(this._element).trigger(i), !i.isDefaultPrevented())) {
                        t && (a._jQueryInterface.call(st(t).not(this._selector), "hide"), e || st(t).data(lt, null));
                        var r = this._getDimension();
                        st(this._element).removeClass(_t).addClass(mt), (this._element.style[r] = 0), this._triggerArray.length && st(this._triggerArray).removeClass(pt).attr("aria-expanded", !0), this.setTransitioning(!0);
                        var o = "scroll" + (r[0].toUpperCase() + r.slice(1)),
                            s = Fn.getTransitionDurationFromElement(this._element);
                        st(this._element).one(Fn.TRANSITION_END, function () {
                            st(n._element).removeClass(mt).addClass(_t).addClass(gt), (n._element.style[r] = ""), n.setTransitioning(!1), st(n._element).trigger(dt.SHOWN);
                        }).emulateTransitionEnd(s), (this._element.style[r] = this._element[o] + "px");
                    }
                }
            }), (t.hide = function () {
                var t = this;
                if (!this._isTransitioning && st(this._element).hasClass(gt)) {
                    var e = st.Event(dt.HIDE);
                    if ((st(this._element).trigger(e), !e.isDefaultPrevented())) {
                        var n = this._getDimension();
                        (this._element.style[n] = this._element.getBoundingClientRect()[n] + "px"), Fn.reflow(this._element), st(this._element).addClass(mt).removeClass(_t).removeClass(gt);
                        var i = this._triggerArray.length;
                        if (0 < i)
                            for (var r = 0; r < i; r++) {
                                var o = this._triggerArray[r],
                                    s = Fn.getSelectorFromElement(o);
                                if (null !== s) st([].slice.call(document.querySelectorAll(s))).hasClass(gt) || st(o).addClass(pt).attr("aria-expanded", !1);
                            }
                        this.setTransitioning(!0);
                        this._element.style[n] = "";
                        var a = Fn.getTransitionDurationFromElement(this._element);
                        st(this._element).one(Fn.TRANSITION_END, function () {
                            t.setTransitioning(!1), st(t._element).removeClass(mt).addClass(_t).trigger(dt.HIDDEN);
                        }).emulateTransitionEnd(a);
                    }
                }
            }), (t.setTransitioning = function (t) {
                this._isTransitioning = t;
            }), (t.dispose = function () {
                st.removeData(this._element, lt), (this._config = null), (this._parent = null), (this._element = null), (this._triggerArray = null), (this._isTransitioning = null);
            }), (t._getConfig = function (t) {
                return ((t = l({}, ut, t)).toggle = Boolean(t.toggle)), Fn.typeCheckConfig(at, t, ft), t;
            }), (t._getDimension = function () {
                return st(this._element).hasClass(vt) ? vt : yt;
            }), (t._getParent = function () {
                var n = this,
                    t = null;
                Fn.isElement(this._config.parent) ? ((t = this._config.parent), "undefined" != typeof this._config.parent.jquery && (t = this._config.parent[0])) : (t = document.querySelector(this._config.parent));
                var e = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]',
                    i = [].slice.call(t.querySelectorAll(e));
                return (st(i).each(function (t, e) {
                    n._addAriaAndCollapsedClass(a._getTargetFromElement(e), [e]);
                }), t);
            }), (t._addAriaAndCollapsedClass = function (t, e) {
                if (t) {
                    var n = st(t).hasClass(gt);
                    e.length && st(e).toggleClass(pt, !n).attr("aria-expanded", n);
                }
            }), (a._getTargetFromElement = function (t) {
                var e = Fn.getSelectorFromElement(t);
                return e ? document.querySelector(e) : null;
            }), (a._jQueryInterface = function (i) {
                return this.each(function () {
                    var t = st(this),
                        e = t.data(lt),
                        n = l({}, ut, t.data(), "object" == typeof i && i ? i : {});
                    if ((!e && n.toggle && /show|hide/.test(i) && (n.toggle = !1), e || ((e = new a(this, n)), t.data(lt, e)), "string" == typeof i)) {
                        if ("undefined" == typeof e[i]) throw new TypeError('No method named "' + i + '"');
                        e[i]();
                    }
                });
            }), s(a, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return ut;
                },
            }, ]), a);
        })()), st(document).on(dt.CLICK_DATA_API, Ct, function (t) {
            "A" === t.currentTarget.tagName && t.preventDefault();
            var n = st(this),
                e = Fn.getSelectorFromElement(this),
                i = [].slice.call(document.querySelectorAll(e));
            st(i).each(function () {
                var t = st(this),
                    e = t.data(lt) ? "toggle" : n.data();
                Tt._jQueryInterface.call(t, e);
            });
        }), (st.fn[at] = Tt._jQueryInterface), (st.fn[at].Constructor = Tt), (st.fn[at].noConflict = function () {
            return (st.fn[at] = ht), Tt._jQueryInterface;
        }), Tt),
        Vn = ((St = "dropdown"), (At = "." + (It = "bs.dropdown")), (Dt = ".data-api"), (wt = (bt = e).fn[St]), (Nt = new RegExp("38|40|27")), (Ot = {
            HIDE: "hide" + At,
            HIDDEN: "hidden" + At,
            SHOW: "show" + At,
            SHOWN: "shown" + At,
            CLICK: "click" + At,
            CLICK_DATA_API: "click" + At + Dt,
            KEYDOWN_DATA_API: "keydown" + At + Dt,
            KEYUP_DATA_API: "keyup" + At + Dt
        }), (kt = "disabled"), (Pt = "show"), (jt = "dropup"), (Ht = "dropright"), (Lt = "dropleft"), (Rt = "dropdown-menu-right"), (xt = "position-static"), (Wt = '[data-toggle="dropdown"]'), (Ut = ".dropdown form"), (qt = ".dropdown-menu"), (Ft = ".navbar-nav"), (Kt = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)"), (Mt = "top-start"), (Qt = "top-end"), (Bt = "bottom-start"), (Vt = "bottom-end"), (Yt = "right-start"), (zt = "left-start"), (Jt = {
            offset: 0,
            flip: !0,
            boundary: "scrollParent",
            reference: "toggle",
            display: "dynamic"
        }), (Zt = {
            offset: "(number|string|function)",
            flip: "boolean",
            boundary: "(string|element)",
            reference: "(string|element)",
            display: "string"
        }), (Gt = (function () {
            function c(t, e) {
                (this._element = t), (this._popper = null), (this._config = this._getConfig(e)), (this._menu = this._getMenuElement()), (this._inNavbar = this._detectNavbar()), this._addEventListeners();
            }
            var t = c.prototype;
            return ((t.toggle = function () {
                if (!this._element.disabled && !bt(this._element).hasClass(kt)) {
                    var t = c._getParentFromElement(this._element),
                        e = bt(this._menu).hasClass(Pt);
                    if ((c._clearMenus(), !e)) {
                        var n = {
                                relatedTarget: this._element
                            },
                            i = bt.Event(Ot.SHOW, n);
                        if ((bt(t).trigger(i), !i.isDefaultPrevented())) {
                            if (!this._inNavbar) {
                                if ("undefined" == typeof h) throw new TypeError("Bootstrap dropdown require Popper.js (https://popper.js.org)");
                                var r = this._element;
                                "parent" === this._config.reference ? (r = t) : Fn.isElement(this._config.reference) && ((r = this._config.reference), "undefined" != typeof this._config.reference.jquery && (r = this._config.reference[0])), "scrollParent" !== this._config.boundary && bt(t).addClass(xt), (this._popper = new h(r, this._menu, this._getPopperConfig()));
                            }
                            "ontouchstart" in document.documentElement && 0 === bt(t).closest(Ft).length && bt(document.body).children().on("mouseover", null, bt.noop), this._element.focus(), this._element.setAttribute("aria-expanded", !0), bt(this._menu).toggleClass(Pt), bt(t).toggleClass(Pt).trigger(bt.Event(Ot.SHOWN, n));
                        }
                    }
                }
            }), (t.dispose = function () {
                bt.removeData(this._element, It), bt(this._element).off(At), (this._element = null), (this._menu = null) !== this._popper && (this._popper.destroy(), (this._popper = null));
            }), (t.update = function () {
                (this._inNavbar = this._detectNavbar()), null !== this._popper && this._popper.scheduleUpdate();
            }), (t._addEventListeners = function () {
                var e = this;
                bt(this._element).on(Ot.CLICK, function (t) {
                    t.preventDefault(), t.stopPropagation(), e.toggle();
                });
            }), (t._getConfig = function (t) {
                return (t = l({}, this.constructor.Default, bt(this._element).data(), t)), Fn.typeCheckConfig(St, t, this.constructor.DefaultType), t;
            }), (t._getMenuElement = function () {
                if (!this._menu) {
                    var t = c._getParentFromElement(this._element);
                    t && (this._menu = t.querySelector(qt));
                }
                return this._menu;
            }), (t._getPlacement = function () {
                var t = bt(this._element.parentNode),
                    e = Bt;
                return t.hasClass(jt) ? ((e = Mt), bt(this._menu).hasClass(Rt) && (e = Qt)) : t.hasClass(Ht) ? (e = Yt) : t.hasClass(Lt) ? (e = zt) : bt(this._menu).hasClass(Rt) && (e = Vt), e;
            }), (t._detectNavbar = function () {
                return 0 < bt(this._element).closest(".navbar").length;
            }), (t._getPopperConfig = function () {
                var e = this,
                    t = {};
                "function" == typeof this._config.offset ? (t.fn = function (t) {
                    return (t.offsets = l({}, t.offsets, e._config.offset(t.offsets) || {})), t;
                }) : (t.offset = this._config.offset);
                var n = {
                    placement: this._getPlacement(),
                    modifiers: {
                        offset: t,
                        flip: {
                            enabled: this._config.flip
                        },
                        preventOverflow: {
                            boundariesElement: this._config.boundary
                        }
                    }
                };
                return "static" === this._config.display && (n.modifiers.applyStyle = {
                    enabled: !1
                }), n;
            }), (c._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = bt(this).data(It);
                    if ((t || ((t = new c(this, "object" == typeof e ? e : null)), bt(this).data(It, t)), "string" == typeof e)) {
                        if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');
                        t[e]();
                    }
                });
            }), (c._clearMenus = function (t) {
                if (!t || (3 !== t.which && ("keyup" !== t.type || 9 === t.which)))
                    for (var e = [].slice.call(document.querySelectorAll(Wt)), n = 0, i = e.length; n < i; n++) {
                        var r = c._getParentFromElement(e[n]),
                            o = bt(e[n]).data(It),
                            s = {
                                relatedTarget: e[n]
                            };
                        if ((t && "click" === t.type && (s.clickEvent = t), o)) {
                            var a = o._menu;
                            if (bt(r).hasClass(Pt) && !(t && (("click" === t.type && /input|textarea/i.test(t.target.tagName)) || ("keyup" === t.type && 9 === t.which)) && bt.contains(r, t.target))) {
                                var l = bt.Event(Ot.HIDE, s);
                                bt(r).trigger(l), l.isDefaultPrevented() || ("ontouchstart" in document.documentElement && bt(document.body).children().off("mouseover", null, bt.noop), e[n].setAttribute("aria-expanded", "false"), bt(a).removeClass(Pt), bt(r).removeClass(Pt).trigger(bt.Event(Ot.HIDDEN, s)));
                            }
                        }
                    }
            }), (c._getParentFromElement = function (t) {
                var e, n = Fn.getSelectorFromElement(t);
                return n && (e = document.querySelector(n)), e || t.parentNode;
            }), (c._dataApiKeydownHandler = function (t) {
                if ((/input|textarea/i.test(t.target.tagName) ? !(32 === t.which || (27 !== t.which && ((40 !== t.which && 38 !== t.which) || bt(t.target).closest(qt).length))) : Nt.test(t.which)) && (t.preventDefault(), t.stopPropagation(), !this.disabled && !bt(this).hasClass(kt))) {
                    var e = c._getParentFromElement(this),
                        n = bt(e).hasClass(Pt);
                    if ((n || (27 === t.which && 32 === t.which)) && (!n || (27 !== t.which && 32 !== t.which))) {
                        var i = [].slice.call(e.querySelectorAll(Kt));
                        if (0 !== i.length) {
                            var r = i.indexOf(t.target);
                            38 === t.which && 0 < r && r--, 40 === t.which && r < i.length - 1 && r++, r < 0 && (r = 0), i[r].focus();
                        }
                    } else {
                        if (27 === t.which) {
                            var o = e.querySelector(Wt);
                            bt(o).trigger("focus");
                        }
                        bt(this).trigger("click");
                    }
                }
            }), s(c, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return Jt;
                },
            }, {
                key: "DefaultType",
                get: function () {
                    return Zt;
                },
            }, ]), c);
        })()), bt(document).on(Ot.KEYDOWN_DATA_API, Wt, Gt._dataApiKeydownHandler).on(Ot.KEYDOWN_DATA_API, qt, Gt._dataApiKeydownHandler).on(Ot.CLICK_DATA_API + " " + Ot.KEYUP_DATA_API, Gt._clearMenus).on(Ot.CLICK_DATA_API, Wt, function (t) {
            t.preventDefault(), t.stopPropagation(), Gt._jQueryInterface.call(bt(this), "toggle");
        }).on(Ot.CLICK_DATA_API, Ut, function (t) {
            t.stopPropagation();
        }), (bt.fn[St] = Gt._jQueryInterface), (bt.fn[St].Constructor = Gt), (bt.fn[St].noConflict = function () {
            return (bt.fn[St] = wt), Gt._jQueryInterface;
        }), Gt),
        Yn = ((Xt = "modal"), (ee = "." + (te = "bs.modal")), (ne = ($t = e).fn[Xt]), (ie = {
            backdrop: !0,
            keyboard: !0,
            focus: !0,
            show: !0
        }), (re = {
            backdrop: "(boolean|string)",
            keyboard: "boolean",
            focus: "boolean",
            show: "boolean"
        }), (oe = {
            HIDE: "hide" + ee,
            HIDDEN: "hidden" + ee,
            SHOW: "show" + ee,
            SHOWN: "shown" + ee,
            FOCUSIN: "focusin" + ee,
            RESIZE: "resize" + ee,
            CLICK_DISMISS: "click.dismiss" + ee,
            KEYDOWN_DISMISS: "keydown.dismiss" + ee,
            MOUSEUP_DISMISS: "mouseup.dismiss" + ee,
            MOUSEDOWN_DISMISS: "mousedown.dismiss" + ee,
            CLICK_DATA_API: "click" + ee + ".data-api",
        }), (se = "modal-scrollbar-measure"), (ae = "modal-backdrop"), (le = "modal-open"), (ce = "fade"), (he = "show"), (ue = ".modal-dialog"), (fe = '[data-toggle="modal"]'), (de = '[data-dismiss="modal"]'), (ge = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"), (_e = ".sticky-top"), (me = (function () {
            function r(t, e) {
                (this._config = this._getConfig(e)), (this._element = t), (this._dialog = t.querySelector(ue)), (this._backdrop = null), (this._isShown = !1), (this._isBodyOverflowing = !1), (this._ignoreBackdropClick = !1), (this._scrollbarWidth = 0);
            }
            var t = r.prototype;
            return ((t.toggle = function (t) {
                return this._isShown ? this.hide() : this.show(t);
            }), (t.show = function (t) {
                var e = this;
                if (!this._isTransitioning && !this._isShown) {
                    $t(this._element).hasClass(ce) && (this._isTransitioning = !0);
                    var n = $t.Event(oe.SHOW, {
                        relatedTarget: t
                    });
                    $t(this._element).trigger(n), this._isShown || n.isDefaultPrevented() || ((this._isShown = !0), this._checkScrollbar(), this._setScrollbar(), this._adjustDialog(), $t(document.body).addClass(le), this._setEscapeEvent(), this._setResizeEvent(), $t(this._element).on(oe.CLICK_DISMISS, de, function (t) {
                        return e.hide(t);
                    }), $t(this._dialog).on(oe.MOUSEDOWN_DISMISS, function () {
                        $t(e._element).one(oe.MOUSEUP_DISMISS, function (t) {
                            $t(t.target).is(e._element) && (e._ignoreBackdropClick = !0);
                        });
                    }), this._showBackdrop(function () {
                        return e._showElement(t);
                    }));
                }
            }), (t.hide = function (t) {
                var e = this;
                if ((t && t.preventDefault(), !this._isTransitioning && this._isShown)) {
                    var n = $t.Event(oe.HIDE);
                    if (($t(this._element).trigger(n), this._isShown && !n.isDefaultPrevented())) {
                        this._isShown = !1;
                        var i = $t(this._element).hasClass(ce);
                        if ((i && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), $t(document).off(oe.FOCUSIN), $t(this._element).removeClass(he), $t(this._element).off(oe.CLICK_DISMISS), $t(this._dialog).off(oe.MOUSEDOWN_DISMISS), i)) {
                            var r = Fn.getTransitionDurationFromElement(this._element);
                            $t(this._element).one(Fn.TRANSITION_END, function (t) {
                                return e._hideModal(t);
                            }).emulateTransitionEnd(r);
                        } else this._hideModal();
                    }
                }
            }), (t.dispose = function () {
                $t.removeData(this._element, te), $t(window, document, this._element, this._backdrop).off(ee), (this._config = null), (this._element = null), (this._dialog = null), (this._backdrop = null), (this._isShown = null), (this._isBodyOverflowing = null), (this._ignoreBackdropClick = null), (this._scrollbarWidth = null);
            }), (t.handleUpdate = function () {
                this._adjustDialog();
            }), (t._getConfig = function (t) {
                return (t = l({}, ie, t)), Fn.typeCheckConfig(Xt, t, re), t;
            }), (t._showElement = function (t) {
                var e = this,
                    n = $t(this._element).hasClass(ce);
                (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE) || document.body.appendChild(this._element), (this._element.style.display = "block"), this._element.removeAttribute("aria-hidden"), (this._element.scrollTop = 0), n && Fn.reflow(this._element), $t(this._element).addClass(he), this._config.focus && this._enforceFocus();
                var i = $t.Event(oe.SHOWN, {
                        relatedTarget: t
                    }),
                    r = function () {
                        e._config.focus && e._element.focus(), (e._isTransitioning = !1), $t(e._element).trigger(i);
                    };
                if (n) {
                    var o = Fn.getTransitionDurationFromElement(this._element);
                    $t(this._dialog).one(Fn.TRANSITION_END, r).emulateTransitionEnd(o);
                } else r();
            }), (t._enforceFocus = function () {
                var e = this;
                $t(document).off(oe.FOCUSIN).on(oe.FOCUSIN, function (t) {
                    document !== t.target && e._element !== t.target && 0 === $t(e._element).has(t.target).length && e._element.focus();
                });
            }), (t._setEscapeEvent = function () {
                var e = this;
                this._isShown && this._config.keyboard ? $t(this._element).on(oe.KEYDOWN_DISMISS, function (t) {
                    27 === t.which && (t.preventDefault(), e.hide());
                }) : this._isShown || $t(this._element).off(oe.KEYDOWN_DISMISS);
            }), (t._setResizeEvent = function () {
                var e = this;
                this._isShown ? $t(window).on(oe.RESIZE, function (t) {
                    return e.handleUpdate(t);
                }) : $t(window).off(oe.RESIZE);
            }), (t._hideModal = function () {
                var t = this;
                (this._element.style.display = "none"), this._element.setAttribute("aria-hidden", !0), (this._isTransitioning = !1), this._showBackdrop(function () {
                    $t(document.body).removeClass(le), t._resetAdjustments(), t._resetScrollbar(), $t(t._element).trigger(oe.HIDDEN);
                });
            }), (t._removeBackdrop = function () {
                this._backdrop && ($t(this._backdrop).remove(), (this._backdrop = null));
            }), (t._showBackdrop = function (t) {
                var e = this,
                    n = $t(this._element).hasClass(ce) ? ce : "";
                if (this._isShown && this._config.backdrop) {
                    if (((this._backdrop = document.createElement("div")), (this._backdrop.className = ae), n && this._backdrop.classList.add(n), $t(this._backdrop).appendTo(document.body), $t(this._element).on(oe.CLICK_DISMISS, function (t) {
                        e._ignoreBackdropClick ? (e._ignoreBackdropClick = !1) : t.target === t.currentTarget && ("static" === e._config.backdrop ? e._element.focus() : e.hide());
                    }), n && Fn.reflow(this._backdrop), $t(this._backdrop).addClass(he), !t))
                        return;
                    if (!n) return void t();
                    var i = Fn.getTransitionDurationFromElement(this._backdrop);
                    $t(this._backdrop).one(Fn.TRANSITION_END, t).emulateTransitionEnd(i);
                } else if (!this._isShown && this._backdrop) {
                    $t(this._backdrop).removeClass(he);
                    var r = function () {
                        e._removeBackdrop(), t && t();
                    };
                    if ($t(this._element).hasClass(ce)) {
                        var o = Fn.getTransitionDurationFromElement(this._backdrop);
                        $t(this._backdrop).one(Fn.TRANSITION_END, r).emulateTransitionEnd(o);
                    } else r();
                } else t && t();
            }), (t._adjustDialog = function () {
                var t = this._element.scrollHeight > document.documentElement.clientHeight;
                !this._isBodyOverflowing && t && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !t && (this._element.style.paddingRight = this._scrollbarWidth + "px");
            }), (t._resetAdjustments = function () {
                (this._element.style.paddingLeft = ""), (this._element.style.paddingRight = "");
            }), (t._checkScrollbar = function () {
                var t = document.body.getBoundingClientRect();
                (this._isBodyOverflowing = t.left + t.right < window.innerWidth), (this._scrollbarWidth = this._getScrollbarWidth());
            }), (t._setScrollbar = function () {
                var r = this;
                if (this._isBodyOverflowing) {
                    var t = [].slice.call(document.querySelectorAll(ge)),
                        e = [].slice.call(document.querySelectorAll(_e));
                    $t(t).each(function (t, e) {
                        var n = e.style.paddingRight,
                            i = $t(e).css("padding-right");
                        $t(e).data("padding-right", n).css("padding-right", parseFloat(i) + r._scrollbarWidth + "px");
                    }), $t(e).each(function (t, e) {
                        var n = e.style.marginRight,
                            i = $t(e).css("margin-right");
                        $t(e).data("margin-right", n).css("margin-right", parseFloat(i) - r._scrollbarWidth + "px");
                    });
                    var n = document.body.style.paddingRight,
                        i = $t(document.body).css("padding-right");
                    $t(document.body).data("padding-right", n).css("padding-right", parseFloat(i) + this._scrollbarWidth + "px");
                }
            }), (t._resetScrollbar = function () {
                var t = [].slice.call(document.querySelectorAll(ge));
                $t(t).each(function (t, e) {
                    var n = $t(e).data("padding-right");
                    $t(e).removeData("padding-right"), (e.style.paddingRight = n || "");
                });
                var e = [].slice.call(document.querySelectorAll("" + _e));
                $t(e).each(function (t, e) {
                    var n = $t(e).data("margin-right");
                    "undefined" != typeof n && $t(e).css("margin-right", n).removeData("margin-right");
                });
                var n = $t(document.body).data("padding-right");
                $t(document.body).removeData("padding-right"), (document.body.style.paddingRight = n || "");
            }), (t._getScrollbarWidth = function () {
                var t = document.createElement("div");
                (t.className = se), document.body.appendChild(t);
                var e = t.getBoundingClientRect().width - t.clientWidth;
                return document.body.removeChild(t), e;
            }), (r._jQueryInterface = function (n, i) {
                return this.each(function () {
                    var t = $t(this).data(te),
                        e = l({}, ie, $t(this).data(), "object" == typeof n && n ? n : {});
                    if ((t || ((t = new r(this, e)), $t(this).data(te, t)), "string" == typeof n)) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n](i);
                    } else e.show && t.show(i);
                });
            }), s(r, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return ie;
                },
            }, ]), r);
        })()), $t(document).on(oe.CLICK_DATA_API, fe, function (t) {
            var e, n = this,
                i = Fn.getSelectorFromElement(this);
            i && (e = document.querySelector(i));
            var r = $t(e).data(te) ? "toggle" : l({}, $t(e).data(), $t(this).data());
            ("A" !== this.tagName && "AREA" !== this.tagName) || t.preventDefault();
            var o = $t(e).one(oe.SHOW, function (t) {
                t.isDefaultPrevented() || o.one(oe.HIDDEN, function () {
                    $t(n).is(":visible") && n.focus();
                });
            });
            me._jQueryInterface.call($t(e), r, this);
        }), ($t.fn[Xt] = me._jQueryInterface), ($t.fn[Xt].Constructor = me), ($t.fn[Xt].noConflict = function () {
            return ($t.fn[Xt] = ne), me._jQueryInterface;
        }), me),
        zn = ((ve = "tooltip"), (Ee = "." + (ye = "bs.tooltip")), (Ce = (pe = e).fn[ve]), (Te = "bs-tooltip"), (be = new RegExp("(^|\\s)" + Te + "\\S+", "g")), (Ae = {
            animation: !0,
            template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !(Ie = {
                AUTO: "auto",
                TOP: "top",
                RIGHT: "right",
                BOTTOM: "bottom",
                LEFT: "left"
            }),
            selector: !(Se = {
                animation: "boolean",
                template: "string",
                title: "(string|element|function)",
                trigger: "string",
                delay: "(number|object)",
                html: "boolean",
                selector: "(string|boolean)",
                placement: "(string|function)",
                offset: "(number|string)",
                container: "(string|element|boolean)",
                fallbackPlacement: "(string|array)",
                boundary: "(string|element)",
            }),
            placement: "top",
            offset: 0,
            container: !1,
            fallbackPlacement: "flip",
            boundary: "scrollParent",
        }), (we = "out"), (Ne = {
            HIDE: "hide" + Ee,
            HIDDEN: "hidden" + Ee,
            SHOW: (De = "show") + Ee,
            SHOWN: "shown" + Ee,
            INSERTED: "inserted" + Ee,
            CLICK: "click" + Ee,
            FOCUSIN: "focusin" + Ee,
            FOCUSOUT: "focusout" + Ee,
            MOUSEENTER: "mouseenter" + Ee,
            MOUSELEAVE: "mouseleave" + Ee,
        }), (Oe = "fade"), (ke = "show"), (Pe = ".tooltip-inner"), (je = ".arrow"), (He = "hover"), (Le = "focus"), (Re = "click"), (xe = "manual"), (We = (function () {
            function i(t, e) {
                if ("undefined" == typeof h) throw new TypeError("Bootstrap tooltips require Popper.js (https://popper.js.org)");
                (this._isEnabled = !0), (this._timeout = 0), (this._hoverState = ""), (this._activeTrigger = {}), (this._popper = null), (this.element = t), (this.config = this._getConfig(e)), (this.tip = null), this._setListeners();
            }
            var t = i.prototype;
            return ((t.enable = function () {
                this._isEnabled = !0;
            }), (t.disable = function () {
                this._isEnabled = !1;
            }), (t.toggleEnabled = function () {
                this._isEnabled = !this._isEnabled;
            }), (t.toggle = function (t) {
                if (this._isEnabled)
                    if (t) {
                        var e = this.constructor.DATA_KEY,
                            n = pe(t.currentTarget).data(e);
                        n || ((n = new this.constructor(t.currentTarget, this._getDelegateConfig())), pe(t.currentTarget).data(e, n)), (n._activeTrigger.click = !n._activeTrigger.click), n._isWithActiveTrigger() ? n._enter(null, n) : n._leave(null, n);
                    } else {
                        if (pe(this.getTipElement()).hasClass(ke)) return void this._leave(null, this);
                        this._enter(null, this);
                    }
            }), (t.dispose = function () {
                clearTimeout(this._timeout), pe.removeData(this.element, this.constructor.DATA_KEY), pe(this.element).off(this.constructor.EVENT_KEY), pe(this.element).closest(".modal").off("hide.bs.modal"), this.tip && pe(this.tip).remove(), (this._isEnabled = null), (this._timeout = null), (this._hoverState = null), (this._activeTrigger = null) !== this._popper && this._popper.destroy(), (this._popper = null), (this.element = null), (this.config = null), (this.tip = null);
            }), (t.show = function () {
                var e = this;
                if ("none" === pe(this.element).css("display")) throw new Error("Please use show on visible elements");
                var t = pe.Event(this.constructor.Event.SHOW);
                if (this.isWithContent() && this._isEnabled) {
                    pe(this.element).trigger(t);
                    var n = pe.contains(this.element.ownerDocument.documentElement, this.element);
                    if (t.isDefaultPrevented() || !n) return;
                    var i = this.getTipElement(),
                        r = Fn.getUID(this.constructor.NAME);
                    i.setAttribute("id", r), this.element.setAttribute("aria-describedby", r), this.setContent(), this.config.animation && pe(i).addClass(Oe);
                    var o = "function" == typeof this.config.placement ? this.config.placement.call(this, i, this.element) : this.config.placement,
                        s = this._getAttachment(o);
                    this.addAttachmentClass(s);
                    var a = !1 === this.config.container ? document.body : pe(document).find(this.config.container);
                    pe(i).data(this.constructor.DATA_KEY, this), pe.contains(this.element.ownerDocument.documentElement, this.tip) || pe(i).appendTo(a), pe(this.element).trigger(this.constructor.Event.INSERTED), (this._popper = new h(this.element, i, {
                        placement: s,
                        modifiers: {
                            offset: {
                                offset: this.config.offset
                            },
                            flip: {
                                behavior: this.config.fallbackPlacement
                            },
                            arrow: {
                                element: je
                            },
                            preventOverflow: {
                                boundariesElement: this.config.boundary
                            }
                        },
                        onCreate: function (t) {
                            t.originalPlacement !== t.placement && e._handlePopperPlacementChange(t);
                        },
                        onUpdate: function (t) {
                            e._handlePopperPlacementChange(t);
                        },
                    })), pe(i).addClass(ke), "ontouchstart" in document.documentElement && pe(document.body).children().on("mouseover", null, pe.noop);
                    var l = function () {
                        e.config.animation && e._fixTransition();
                        var t = e._hoverState;
                        (e._hoverState = null), pe(e.element).trigger(e.constructor.Event.SHOWN), t === we && e._leave(null, e);
                    };
                    if (pe(this.tip).hasClass(Oe)) {
                        var c = Fn.getTransitionDurationFromElement(this.tip);
                        pe(this.tip).one(Fn.TRANSITION_END, l).emulateTransitionEnd(c);
                    } else l();
                }
            }), (t.hide = function (t) {
                var e = this,
                    n = this.getTipElement(),
                    i = pe.Event(this.constructor.Event.HIDE),
                    r = function () {
                        e._hoverState !== De && n.parentNode && n.parentNode.removeChild(n), e._cleanTipClass(), e.element.removeAttribute("aria-describedby"), pe(e.element).trigger(e.constructor.Event.HIDDEN), null !== e._popper && e._popper.destroy(), t && t();
                    };
                if ((pe(this.element).trigger(i), !i.isDefaultPrevented())) {
                    if ((pe(n).removeClass(ke), "ontouchstart" in document.documentElement && pe(document.body).children().off("mouseover", null, pe.noop), (this._activeTrigger[Re] = !1), (this._activeTrigger[Le] = !1), (this._activeTrigger[He] = !1), pe(this.tip).hasClass(Oe))) {
                        var o = Fn.getTransitionDurationFromElement(n);
                        pe(n).one(Fn.TRANSITION_END, r).emulateTransitionEnd(o);
                    } else r();
                    this._hoverState = "";
                }
            }), (t.update = function () {
                null !== this._popper && this._popper.scheduleUpdate();
            }), (t.isWithContent = function () {
                return Boolean(this.getTitle());
            }), (t.addAttachmentClass = function (t) {
                pe(this.getTipElement()).addClass(Te + "-" + t);
            }), (t.getTipElement = function () {
                return (this.tip = this.tip || pe(this.config.template)[0]), this.tip;
            }), (t.setContent = function () {
                var t = this.getTipElement();
                this.setElementContent(pe(t.querySelectorAll(Pe)), this.getTitle()), pe(t).removeClass(Oe + " " + ke);
            }), (t.setElementContent = function (t, e) {
                var n = this.config.html;
                "object" == typeof e && (e.nodeType || e.jquery) ? (n ? pe(e).parent().is(t) || t.empty().append(e) : t.text(pe(e).text())) : t[n ? "html" : "text"](e);
            }), (t.getTitle = function () {
                var t = this.element.getAttribute("data-original-title");
                return t || (t = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), t;
            }), (t._getAttachment = function (t) {
                return Ie[t.toUpperCase()];
            }), (t._setListeners = function () {
                var i = this;
                this.config.trigger.split(" ").forEach(function (t) {
                    if ("click" === t)
                        pe(i.element).on(i.constructor.Event.CLICK, i.config.selector, function (t) {
                            return i.toggle(t);
                        });
                    else if (t !== xe) {
                        var e = t === He ? i.constructor.Event.MOUSEENTER : i.constructor.Event.FOCUSIN,
                            n = t === He ? i.constructor.Event.MOUSELEAVE : i.constructor.Event.FOCUSOUT;
                        pe(i.element).on(e, i.config.selector, function (t) {
                            return i._enter(t);
                        }).on(n, i.config.selector, function (t) {
                            return i._leave(t);
                        });
                    }
                    pe(i.element).closest(".modal").on("hide.bs.modal", function () {
                        return i.hide();
                    });
                }), this.config.selector ? (this.config = l({}, this.config, {
                    trigger: "manual",
                    selector: ""
                })) : this._fixTitle();
            }), (t._fixTitle = function () {
                var t = typeof this.element.getAttribute("data-original-title");
                (this.element.getAttribute("title") || "string" !== t) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
            }), (t._enter = function (t, e) {
                var n = this.constructor.DATA_KEY;
                (e = e || pe(t.currentTarget).data(n)) || ((e = new this.constructor(t.currentTarget, this._getDelegateConfig())), pe(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusin" === t.type ? Le : He] = !0), pe(e.getTipElement()).hasClass(ke) || e._hoverState === De ? (e._hoverState = De) : (clearTimeout(e._timeout), (e._hoverState = De), e.config.delay && e.config.delay.show ? (e._timeout = setTimeout(function () {
                    e._hoverState === De && e.show();
                }, e.config.delay.show)) : e.show());
            }), (t._leave = function (t, e) {
                var n = this.constructor.DATA_KEY;
                (e = e || pe(t.currentTarget).data(n)) || ((e = new this.constructor(t.currentTarget, this._getDelegateConfig())), pe(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusout" === t.type ? Le : He] = !1), e._isWithActiveTrigger() || (clearTimeout(e._timeout), (e._hoverState = we), e.config.delay && e.config.delay.hide ? (e._timeout = setTimeout(function () {
                    e._hoverState === we && e.hide();
                }, e.config.delay.hide)) : e.hide());
            }), (t._isWithActiveTrigger = function () {
                for (var t in this._activeTrigger)
                    if (this._activeTrigger[t]) return !0;
                return !1;
            }), (t._getConfig = function (t) {
                return ("number" == typeof (t = l({}, this.constructor.Default, pe(this.element).data(), "object" == typeof t && t ? t : {})).delay && (t.delay = {
                    show: t.delay,
                    hide: t.delay
                }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), Fn.typeCheckConfig(ve, t, this.constructor.DefaultType), t);
            }), (t._getDelegateConfig = function () {
                var t = {};
                if (this.config)
                    for (var e in this.config) this.constructor.Default[e] !== this.config[e] && (t[e] = this.config[e]);
                return t;
            }), (t._cleanTipClass = function () {
                var t = pe(this.getTipElement()),
                    e = t.attr("class").match(be);
                null !== e && e.length && t.removeClass(e.join(""));
            }), (t._handlePopperPlacementChange = function (t) {
                var e = t.instance;
                (this.tip = e.popper), this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(t.placement));
            }), (t._fixTransition = function () {
                var t = this.getTipElement(),
                    e = this.config.animation;
                null === t.getAttribute("x-placement") && (pe(t).removeClass(Oe), (this.config.animation = !1), this.hide(), this.show(), (this.config.animation = e));
            }), (i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = pe(this).data(ye),
                        e = "object" == typeof n && n;
                    if ((t || !/dispose|hide/.test(n)) && (t || ((t = new i(this, e)), pe(this).data(ye, t)), "string" == typeof n)) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]();
                    }
                });
            }), s(i, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return Ae;
                },
            }, {
                key: "NAME",
                get: function () {
                    return ve;
                },
            }, {
                key: "DATA_KEY",
                get: function () {
                    return ye;
                },
            }, {
                key: "Event",
                get: function () {
                    return Ne;
                },
            }, {
                key: "EVENT_KEY",
                get: function () {
                    return Ee;
                },
            }, {
                key: "DefaultType",
                get: function () {
                    return Se;
                },
            }, ]), i);
        })()), (pe.fn[ve] = We._jQueryInterface), (pe.fn[ve].Constructor = We), (pe.fn[ve].noConflict = function () {
            return (pe.fn[ve] = Ce), We._jQueryInterface;
        }), We),
        Jn = ((qe = "popover"), (Ke = "." + (Fe = "bs.popover")), (Me = (Ue = e).fn[qe]), (Qe = "bs-popover"), (Be = new RegExp("(^|\\s)" + Qe + "\\S+", "g")), (Ve = l({}, zn.Default, {
            placement: "right",
            trigger: "click",
            content: "",
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        })), (Ye = l({}, zn.DefaultType, {
            content: "(string|element|function)"
        })), (ze = "fade"), (Ze = ".popover-header"), (Ge = ".popover-body"), ($e = {
            HIDE: "hide" + Ke,
            HIDDEN: "hidden" + Ke,
            SHOW: (Je = "show") + Ke,
            SHOWN: "shown" + Ke,
            INSERTED: "inserted" + Ke,
            CLICK: "click" + Ke,
            FOCUSIN: "focusin" + Ke,
            FOCUSOUT: "focusout" + Ke,
            MOUSEENTER: "mouseenter" + Ke,
            MOUSELEAVE: "mouseleave" + Ke,
        }), (Xe = (function (t) {
            var e, n;

            function i() {
                return t.apply(this, arguments) || this;
            }
            (n = t), ((e = i).prototype = Object.create(n.prototype)), ((e.prototype.constructor = e).__proto__ = n);
            var r = i.prototype;
            return ((r.isWithContent = function () {
                return this.getTitle() || this._getContent();
            }), (r.addAttachmentClass = function (t) {
                Ue(this.getTipElement()).addClass(Qe + "-" + t);
            }), (r.getTipElement = function () {
                return (this.tip = this.tip || Ue(this.config.template)[0]), this.tip;
            }), (r.setContent = function () {
                var t = Ue(this.getTipElement());
                this.setElementContent(t.find(Ze), this.getTitle());
                var e = this._getContent();
                "function" == typeof e && (e = e.call(this.element)), this.setElementContent(t.find(Ge), e), t.removeClass(ze + " " + Je);
            }), (r._getContent = function () {
                return this.element.getAttribute("data-content") || this.config.content;
            }), (r._cleanTipClass = function () {
                var t = Ue(this.getTipElement()),
                    e = t.attr("class").match(Be);
                null !== e && 0 < e.length && t.removeClass(e.join(""));
            }), (i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = Ue(this).data(Fe),
                        e = "object" == typeof n ? n : null;
                    if ((t || !/destroy|hide/.test(n)) && (t || ((t = new i(this, e)), Ue(this).data(Fe, t)), "string" == typeof n)) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]();
                    }
                });
            }), s(i, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return Ve;
                },
            }, {
                key: "NAME",
                get: function () {
                    return qe;
                },
            }, {
                key: "DATA_KEY",
                get: function () {
                    return Fe;
                },
            }, {
                key: "Event",
                get: function () {
                    return $e;
                },
            }, {
                key: "EVENT_KEY",
                get: function () {
                    return Ke;
                },
            }, {
                key: "DefaultType",
                get: function () {
                    return Ye;
                },
            }, ]), i);
        })(zn)), (Ue.fn[qe] = Xe._jQueryInterface), (Ue.fn[qe].Constructor = Xe), (Ue.fn[qe].noConflict = function () {
            return (Ue.fn[qe] = Me), Xe._jQueryInterface;
        }), Xe),
        Zn = ((en = "scrollspy"), (rn = "." + (nn = "bs.scrollspy")), (on = (tn = e).fn[en]), (sn = {
            offset: 10,
            method: "auto",
            target: ""
        }), (an = {
            offset: "number",
            method: "string",
            target: "(string|element)"
        }), (ln = {
            ACTIVATE: "activate" + rn,
            SCROLL: "scroll" + rn,
            LOAD_DATA_API: "load" + rn + ".data-api"
        }), (cn = "dropdown-item"), (hn = "active"), (un = '[data-spy="scroll"]'), (fn = ".active"), (dn = ".nav, .list-group"), (gn = ".nav-link"), (_n = ".nav-item"), (mn = ".list-group-item"), (pn = ".dropdown"), (vn = ".dropdown-item"), (yn = ".dropdown-toggle"), (En = "offset"), (Cn = "position"), (Tn = (function () {
            function n(t, e) {
                var n = this;
                (this._element = t), (this._scrollElement = "BODY" === t.tagName ? window : t), (this._config = this._getConfig(e)), (this._selector = this._config.target + " " + gn + "," + this._config.target + " " + mn + "," + this._config.target + " " + vn), (this._offsets = []), (this._targets = []), (this._activeTarget = null), (this._scrollHeight = 0), tn(this._scrollElement).on(ln.SCROLL, function (t) {
                    return n._process(t);
                }), this.refresh(), this._process();
            }
            var t = n.prototype;
            return ((t.refresh = function () {
                var e = this,
                    t = this._scrollElement === this._scrollElement.window ? En : Cn,
                    r = "auto" === this._config.method ? t : this._config.method,
                    o = r === Cn ? this._getScrollTop() : 0;
                (this._offsets = []), (this._targets = []), (this._scrollHeight = this._getScrollHeight()), [].slice.call(document.querySelectorAll(this._selector)).map(function (t) {
                    var e, n = Fn.getSelectorFromElement(t);
                    if ((n && (e = document.querySelector(n)), e)) {
                        var i = e.getBoundingClientRect();
                        if (i.width || i.height) return [tn(e)[r]().top + o, n];
                    }
                    return null;
                }).filter(function (t) {
                    return t;
                }).sort(function (t, e) {
                    return t[0] - e[0];
                }).forEach(function (t) {
                    e._offsets.push(t[0]), e._targets.push(t[1]);
                });
            }), (t.dispose = function () {
                tn.removeData(this._element, nn), tn(this._scrollElement).off(rn), (this._element = null), (this._scrollElement = null), (this._config = null), (this._selector = null), (this._offsets = null), (this._targets = null), (this._activeTarget = null), (this._scrollHeight = null);
            }), (t._getConfig = function (t) {
                if ("string" != typeof (t = l({}, sn, "object" == typeof t && t ? t : {})).target) {
                    var e = tn(t.target).attr("id");
                    e || ((e = Fn.getUID(en)), tn(t.target).attr("id", e)), (t.target = "#" + e);
                }
                return Fn.typeCheckConfig(en, t, an), t;
            }), (t._getScrollTop = function () {
                return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
            }), (t._getScrollHeight = function () {
                return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
            }), (t._getOffsetHeight = function () {
                return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
            }), (t._process = function () {
                var t = this._getScrollTop() + this._config.offset,
                    e = this._getScrollHeight(),
                    n = this._config.offset + e - this._getOffsetHeight();
                if ((this._scrollHeight !== e && this.refresh(), n <= t)) {
                    var i = this._targets[this._targets.length - 1];
                    this._activeTarget !== i && this._activate(i);
                } else {
                    if (this._activeTarget && t < this._offsets[0] && 0 < this._offsets[0]) return (this._activeTarget = null), void this._clear();
                    for (var r = this._offsets.length; r--;) {
                        this._activeTarget !== this._targets[r] && t >= this._offsets[r] && ("undefined" == typeof this._offsets[r + 1] || t < this._offsets[r + 1]) && this._activate(this._targets[r]);
                    }
                }
            }), (t._activate = function (e) {
                (this._activeTarget = e), this._clear();
                var t = this._selector.split(",");
                t = t.map(function (t) {
                    return t + '[data-target="' + e + '"],' + t + '[href="' + e + '"]';
                });
                var n = tn([].slice.call(document.querySelectorAll(t.join(","))));
                n.hasClass(cn) ? (n.closest(pn).find(yn).addClass(hn), n.addClass(hn)) : (n.addClass(hn), n.parents(dn).prev(gn + ", " + mn).addClass(hn), n.parents(dn).prev(_n).children(gn).addClass(hn)), tn(this._scrollElement).trigger(ln.ACTIVATE, {
                    relatedTarget: e
                });
            }), (t._clear = function () {
                var t = [].slice.call(document.querySelectorAll(this._selector));
                tn(t).filter(fn).removeClass(hn);
            }), (n._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = tn(this).data(nn);
                    if ((t || ((t = new n(this, "object" == typeof e && e)), tn(this).data(nn, t)), "string" == typeof e)) {
                        if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');
                        t[e]();
                    }
                });
            }), s(n, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, {
                key: "Default",
                get: function () {
                    return sn;
                },
            }, ]), n);
        })()), tn(window).on(ln.LOAD_DATA_API, function () {
            for (var t = [].slice.call(document.querySelectorAll(un)), e = t.length; e--;) {
                var n = tn(t[e]);
                Tn._jQueryInterface.call(n, n.data());
            }
        }), (tn.fn[en] = Tn._jQueryInterface), (tn.fn[en].Constructor = Tn), (tn.fn[en].noConflict = function () {
            return (tn.fn[en] = on), Tn._jQueryInterface;
        }), Tn),
        Gn = ((In = "." + (Sn = "bs.tab")), (An = (bn = e).fn.tab), (Dn = {
            HIDE: "hide" + In,
            HIDDEN: "hidden" + In,
            SHOW: "show" + In,
            SHOWN: "shown" + In,
            CLICK_DATA_API: "click" + In + ".data-api"
        }), (wn = "dropdown-menu"), (Nn = "active"), (On = "disabled"), (kn = "fade"), (Pn = "show"), (jn = ".dropdown"), (Hn = ".nav, .list-group"), (Ln = ".active"), (Rn = "> li > .active"), (xn = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]'), (Wn = ".dropdown-toggle"), (Un = "> .dropdown-menu .active"), (qn = (function () {
            function i(t) {
                this._element = t;
            }
            var t = i.prototype;
            return ((t.show = function () {
                var n = this;
                if (!((this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && bn(this._element).hasClass(Nn)) || bn(this._element).hasClass(On))) {
                    var t, i, e = bn(this._element).closest(Hn)[0],
                        r = Fn.getSelectorFromElement(this._element);
                    if (e) {
                        var o = "UL" === e.nodeName ? Rn : Ln;
                        i = (i = bn.makeArray(bn(e).find(o)))[i.length - 1];
                    }
                    var s = bn.Event(Dn.HIDE, {
                            relatedTarget: this._element
                        }),
                        a = bn.Event(Dn.SHOW, {
                            relatedTarget: i
                        });
                    if ((i && bn(i).trigger(s), bn(this._element).trigger(a), !a.isDefaultPrevented() && !s.isDefaultPrevented())) {
                        r && (t = document.querySelector(r)), this._activate(this._element, e);
                        var l = function () {
                            var t = bn.Event(Dn.HIDDEN, {
                                    relatedTarget: n._element
                                }),
                                e = bn.Event(Dn.SHOWN, {
                                    relatedTarget: i
                                });
                            bn(i).trigger(t), bn(n._element).trigger(e);
                        };
                        t ? this._activate(t, t.parentNode, l) : l();
                    }
                }
            }), (t.dispose = function () {
                bn.removeData(this._element, Sn), (this._element = null);
            }), (t._activate = function (t, e, n) {
                var i = this,
                    r = ("UL" === e.nodeName ? bn(e).find(Rn) : bn(e).children(Ln))[0],
                    o = n && r && bn(r).hasClass(kn),
                    s = function () {
                        return i._transitionComplete(t, r, n);
                    };
                if (r && o) {
                    var a = Fn.getTransitionDurationFromElement(r);
                    bn(r).one(Fn.TRANSITION_END, s).emulateTransitionEnd(a);
                } else s();
            }), (t._transitionComplete = function (t, e, n) {
                if (e) {
                    bn(e).removeClass(Pn + " " + Nn);
                    var i = bn(e.parentNode).find(Un)[0];
                    i && bn(i).removeClass(Nn), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1);
                }
                if ((bn(t).addClass(Nn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), Fn.reflow(t), bn(t).addClass(Pn), t.parentNode && bn(t.parentNode).hasClass(wn))) {
                    var r = bn(t).closest(jn)[0];
                    if (r) {
                        var o = [].slice.call(r.querySelectorAll(Wn));
                        bn(o).addClass(Nn);
                    }
                    t.setAttribute("aria-expanded", !0);
                }
                n && n();
            }), (i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = bn(this),
                        e = t.data(Sn);
                    if ((e || ((e = new i(this)), t.data(Sn, e)), "string" == typeof n)) {
                        if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
                        e[n]();
                    }
                });
            }), s(i, null, [{
                key: "VERSION",
                get: function () {
                    return "4.1.3";
                },
            }, ]), i);
        })()), bn(document).on(Dn.CLICK_DATA_API, xn, function (t) {
            t.preventDefault(), qn._jQueryInterface.call(bn(this), "show");
        }), (bn.fn.tab = qn._jQueryInterface), (bn.fn.tab.Constructor = qn), (bn.fn.tab.noConflict = function () {
            return (bn.fn.tab = An), qn._jQueryInterface;
        }), qn);
    !(function (t) {
        if ("undefined" == typeof t) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
        var e = t.fn.jquery.split(" ")[0].split(".");
        if ((e[0] < 2 && e[1] < 9) || (1 === e[0] && 9 === e[1] && e[2] < 1) || 4 <= e[0]) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
    })(e), (t.Util = Fn), (t.Alert = Kn), (t.Button = Mn), (t.Carousel = Qn), (t.Collapse = Bn), (t.Dropdown = Vn), (t.Modal = Yn), (t.Popover = Jn), (t.Scrollspy = Zn), (t.Tab = Gn), (t.Tooltip = zn), Object.defineProperty(t, "__esModule", {
        value: !0
    });
});
/*end the bootstrap js code*/

// Guest wishlist
var wish_list = new Array();
var productId = new Array();
// Guest wishlist::END

(function ($) {
    "use strict"
    wishList();
    $('.wishlist').on('click',function (){

        toastr.error('You need to login', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
    });

    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }


    //code by Akash here
    var is_auth = $('.auth-check').val();

    if (is_auth == 1 && localStorage.getItem('guest_cart_items') === null) {
        cartList();
    } else {
        guestCartList();
    }

    if (is_auth == 1) {
        wishList();
    }


    //affiliate url generator
    $('#genurl').on('click',function () {
        var campaign = $('#campaign').val();
        var url = $('#url').val();
        var ref = $('#ref').val();

        if (url){
            var  custom_url = url+ref;
            if (campaign){
                custom_url+='&campaign='+campaign;
            }
        }else{
            var custom_url = $('#default_url').val();
            if (campaign){
                custom_url+='&campaign='+campaign;
            }
        }
        $('#link').val('');
        $('#link').val(custom_url);
        $('#link').focus();
    });
    

    compareList();
    //code by Akash ends here
    function parallax() {
        $('.bg--parallax').each(function () {
            var el = $(this),
                xpos = "50%",
                windowHeight = $(window).height();
            if (isMobile.any()) {
                $(this).css('background-attachment', 'scroll');
            } else {
                $(window).scroll(function () {
                    var current = $(window).scrollTop(),
                        top = el.offset().top,
                        height = el.outerHeight();
                    if (top + height < current || top > current + windowHeight) {
                        return;
                    }
                    el.css('backgroundPosition', xpos + " " + Math.round((top - current) * 0.2) + "px");
                });
            }
        });
    }

    function backgroundImage() {
        var databackground = $('[data-background]');
        databackground.each(function () {
            if ($(this).attr('data-background')) {
                var image_path = $(this).attr('data-background');
                $(this).css({
                    'background': 'url(' + image_path + ')'
                });
            }
        });
    }

    function siteToggleAction() {
        var navSidebar = $('.navigation--sidebar'),
            filterSidebar = $('.ps-filter--sidebar');
        $('.menu-toggle-open').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('active')
            navSidebar.toggleClass('active');
            $('.ps-site-overlay').toggleClass('active');
        });

        $('.ps-toggle--sidebar').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $(this).toggleClass('active');
            $(this).siblings('a').removeClass('active');
            $(url).toggleClass('active');
            $(url).siblings('.ps-panel--sidebar').removeClass('active');
            $('.ps-site-overlay').toggleClass('active');
        });

        $('#filter-sidebar').on('click', function (e) {
            e.preventDefault();
            filterSidebar.addClass('active');
            $('.ps-site-overlay').addClass('active');
        });

        $('.ps-filter--sidebar .ps-filter__header .ps-btn--close').on('click', function (e) {
            e.preventDefault();
            filterSidebar.removeClass('active');
            $('.ps-site-overlay').removeClass('active');
        });

        $('body').on("click", function (e) {
            if ($(e.target).siblings(".ps-panel--sidebar").hasClass('active')) {
                $('.ps-panel--sidebar').removeClass('active');
                $('.ps-site-overlay').removeClass('active');
            }
        });
    }

    function subMenuToggle() {
        $('.menu--mobile .menu-item-has-children > .sub-toggle').on('click', function (e) {
            e.preventDefault();
            var current = $(this).parent('.menu-item-has-children')
            $(this).toggleClass('active');
            current.siblings().find('.sub-toggle').removeClass('active');
            current.children('.sub-menu').slideToggle(350);
            current.siblings().find('.sub-menu').slideUp(350);
            if (current.hasClass('has-mega-menu')) {
                current.children('.mega-menu').slideToggle(350);
                current.siblings('.has-mega-menu').find('.mega-menu').slideUp(350);
            }

        });
        $('.menu--mobile .has-mega-menu .mega-menu__column .sub-toggle').on('click', function (e) {
            e.preventDefault();
            var current = $(this).closest('.mega-menu__column')
            $(this).toggleClass('active');
            current.siblings().find('.sub-toggle').removeClass('active');
            current.children('.mega-menu__list').slideToggle(350);
            current.siblings().find('.mega-menu__list').slideUp(350);
        });
        var listCategories = $('.ps-list--categories');
        if (listCategories.length > 0) {
            $('.ps-list--categories .menu-item-has-children > .sub-toggle').on('click', function (e) {
                e.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                $(this).toggleClass('active');
                current.siblings().find('.sub-toggle').removeClass('active');
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
                if (current.hasClass('has-mega-menu')) {
                    current.children('.mega-menu').slideToggle(350);
                    current.siblings('.has-mega-menu').find('.mega-menu').slideUp(350);
                }

            });
        }
    }

    function stickyHeader() {
        var header = $('.header'),
            scrollPosition = 0,
            checkpoint = 50;
        header.each(function () {
            if ($(this).data('sticky') === true) {
                var el = $(this);
                $(window).scroll(function () {

                    var currentPosition = $(this).scrollTop();
                    if (currentPosition > checkpoint) {
                        el.addClass('header--sticky');
                    } else {
                        el.removeClass('header--sticky');
                    }
                });
            }
        })

        var stickyCart = $('#cart-sticky');
        if (stickyCart.length > 0) {
            $(window).scroll(function () {
                var currentPosition = $(this).scrollTop();
                if (currentPosition > checkpoint) {
                    stickyCart.addClass('active');
                } else {
                    stickyCart.removeClass('active');
                }
            });
        }
    }

    function owlCarouselConfig() {
        var target = $('.owl-slider');
        if (target.length > 0) {
            target.each(function () {
                var el = $(this),
                    dataAuto = el.data('owl-auto'),
                    dataLoop = el.data('owl-loop'),
                    dataSpeed = el.data('owl-speed'),
                    dataGap = el.data('owl-gap'),
                    dataNav = el.data('owl-nav'),
                    dataDots = el.data('owl-dots'),
                    dataAnimateIn = (el.data('owl-animate-in')) ? el.data('owl-animate-in') : '',
                    dataAnimateOut = (el.data('owl-animate-out')) ? el.data('owl-animate-out') : '',
                    dataDefaultItem = el.data('owl-item'),
                    dataItemXS = el.data('owl-item-xs'),
                    dataItemSM = el.data('owl-item-sm'),
                    dataItemMD = el.data('owl-item-md'),
                    dataItemLG = el.data('owl-item-lg'),
                    dataItemXL = el.data('owl-item-xl'),
                    dataNavLeft = (el.data('owl-nav-left')) ? el.data('owl-nav-left') : "<i class='icon-chevron-left'></i>",
                    dataNavRight = (el.data('owl-nav-right')) ? el.data('owl-nav-right') : "<i class='icon-chevron-right'></i>",
                    duration = el.data('owl-duration'),
                    datamouseDrag = (el.data('owl-mousedrag') == 'on') ? true : false;
                if (target.children('div, span, a, img, h1, h2, h3, h4, h5, h5').length >= 2) {
                    el.owlCarousel({
                        animateIn: dataAnimateIn,
                        animateOut: dataAnimateOut,
                        margin: dataGap,
                        autoplay: dataAuto,
                        autoplayTimeout: dataSpeed,
                        autoplayHoverPause: true,
                        loop: dataLoop,
                        nav: dataNav,
                        mouseDrag: datamouseDrag,
                        touchDrag: true,
                        autoplaySpeed: duration,
                        navSpeed: duration,
                        dotsSpeed: duration,
                        dragEndSpeed: duration,
                        navText: [dataNavLeft, dataNavRight],
                        dots: dataDots,
                        items: dataDefaultItem,
                        responsive: {
                            0: {
                                items: dataItemXS
                            },
                            480: {
                                items: dataItemSM
                            },
                            768: {
                                items: dataItemMD
                            },
                            992: {
                                items: dataItemLG
                            },
                            1200: {
                                items: dataItemXL
                            },
                            1680: {
                                items: dataDefaultItem
                            }
                        }
                    });
                }

            });
        }
    }

    function masonry($selector) {
        var masonry = $($selector);
        if (masonry.length > 0) {
            if (masonry.hasClass('filter')) {
                masonry.imagesLoaded(function () {
                    masonry.isotope({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: "*"
                    });
                });
                var filters = masonry.closest('.masonry-root').find('.ps-masonry-filter > li > a');
                filters.on('click', function (e) {
                    e.preventDefault();
                    var selector = $(this).attr('href');
                    filters.find('a').removeClass('current');
                    $(this).parent('li').addClass('current');
                    $(this).parent('li').siblings('li').removeClass('current');
                    $(this).closest('.masonry-root').find('.ps-masonry').isotope({
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: selector
                    });
                    return false;
                });
            } else {
                masonry.imagesLoaded(function () {
                    masonry.masonry({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item'
                    });
                });
            }
        }
    }


    function slickConfig() {
        var product = $('.ps-product--detail');
        if (product.length > 0) {
            var primary = product.find('.ps-product__gallery'),
                second = product.find('.ps-product__variants'),
                vertical = product.find('.ps-product__thumbnail').data('vertical');
            primary.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.ps-product__variants',
                fade: true,
                dots: false,
                infinite: false,
                arrows: primary.data('arrow'),
                prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
            });
            second.slick({
                slidesToShow: second.data('item'),
                slidesToScroll: 1,
                infinite: false,
                arrows: second.data('arrow'),
                focusOnSelect: true,
                prevArrow: "<a href='#'><i class='fa fa-angle-up'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-down'></i></a>",
                asNavFor: '.ps-product__gallery',
                vertical: vertical,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: second.data('arrow'),
                            slidesToShow: 4,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            vertical: false,
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>"
                        }
                    },
                ]
            });
        }
    }

    function tabs() {
        $('.ps-tab-list  li > a ').on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(this).closest('li').siblings('li').removeClass('active');
            $(this).closest('li').addClass('active');
            $(target).addClass('active');
            $(target).siblings('.ps-tab').removeClass('active');
        });
        $('.ps-tab-list.owl-slider .owl-item a').on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(this).closest('.owl-item').siblings('.owl-item').removeClass('active');
            $(this).closest('.owl-item').addClass('active');
            $(target).addClass('active');
            $(target).siblings('.ps-tab').removeClass('active');
        });
    }

    function rating() {
        $('select.ps-rating').each(function () {
            var readOnly;
            if ($(this).attr('data-read-only') == 'true') {
                readOnly = true
            } else {
                readOnly = false;
            }
            $(this).barrating({
                theme: 'fontawesome-stars',
                readonly: readOnly,
                emptyValue: '0'
            });
        });
    }

    function productLightbox() {
        var product = $('.ps-product--detail');
        if (product.length > 0) {
            $('.ps-product__gallery').lightGallery({
                selector: '.item a',
                thumbnail: true,
                share: false,
                fullScreen: false,
                autoplay: false,
                autoplayControls: false,
                actualSize: false
            });
            if (product.hasClass('ps-product--sticky')) {
                $('.ps-product__thumbnail').lightGallery({
                    selector: '.item a',
                    thumbnail: true,
                    share: false,
                    fullScreen: false,
                    autoplay: false,
                    autoplayControls: false,
                    actualSize: false
                });
            }
        }
        $('.ps-gallery--image').lightGallery({
            selector: '.ps-gallery__item',
            thumbnail: true,
            share: false,
            fullScreen: false,
            autoplay: false,
            autoplayControls: false,
            actualSize: false
        });
        $('.ps-video').lightGallery({
            thumbnail: false,
            share: false,
            fullScreen: false,
            autoplay: false,
            autoplayControls: false,
            actualSize: false
        });
    }

    function backToTop() {
        var scrollPos = 0;
        var element = $('#back2top');
        $(window).scroll(function () {
            var scrollCur = $(window).scrollTop();
            if (scrollCur > scrollPos) {
                // scroll down
                if (scrollCur > 500) {
                    element.addClass('active');
                } else {
                    element.removeClass('active');
                }
            } else {
                // scroll up
                element.removeClass('active');
            }

            scrollPos = scrollCur;
        });

        element.on('click', function () {
            $('html, body').animate({
                scrollTop: '0px'
            }, 800);
        });
    }

    function filterSlider() {
        var el = $('.ps-slider');
        var min = el.siblings().find('.ps-slider__min');
        var max = el.siblings().find('.ps-slider__max');
        var defaultMinValue = el.data('default-min');
        var defaultMaxValue = el.data('default-max');
        var maxValue = el.data('max');
        var step = el.data('step');
        if (el.length > 0) {
            el.slider({
                min: 0,
                max: maxValue,
                step: step,
                range: true,
                values: [defaultMinValue, defaultMaxValue],
                slide: function (event, ui) {
                    var values = ui.values;
                    min.text('$' + values[0]);
                    max.text('$' + values[1]);
                }
            });
            var values = el.slider("option", "values");
            min.text('$' + values[0]);
            max.text('$' + values[1]);
        } else {
            // return false;
        }
    }

    function modalInit() {
        var modal = $('.ps-modal');
        if (modal.length) {
            if (modal.hasClass('active')) {
                $('body').css('overflow-y', 'hidden');
            }
        }
        modal.find('.ps-modal__close, .ps-btn--close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.ps-modal').removeClass('active');
        });
        $('.ps-modal-link').on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).addClass('active');
            $("body").css('overflow-y', 'hidden');
        });
        $('.ps-modal').on("click", function (event) {
            if (!$(event.target).closest(".ps-modal__container").length) {
                modal.removeClass('active');
                $("body").css('overflow-y', 'auto');
            }
        });
    }

    function searchInit() {
        var searchbox = $('.ps-search');
        $('.ps-search-btn').on('click', function (e) {
            e.preventDefault();
            searchbox.addClass('active');
        });
        searchbox.find('.ps-btn--close').on('click', function (e) {
            e.preventDefault();
            searchbox.removeClass('active');
        });
    }



    function productFilterToggle() {
        $('.ps-filter__trigger').on('click', function (e) {
            e.preventDefault();
            var el = $(this);
            el.find('.ps-filter__icon').toggleClass('active');
            el.closest('.ps-filter').find('.ps-filter__content').slideToggle();
        });
        if ($('.ps-sidebar--home').length > 0) {
            $('.ps-sidebar--home > .ps-sidebar__header > a').on('click', function (e) {
                e.preventDefault();
                $(this).closest('.ps-sidebar--home').children('.ps-sidebar__content').slideToggle();
            })
        }
    }

    function mainSlider() {
        var homeBanner = $('.ps-carousel--animate');
        homeBanner.slick({
            autoplay: true,
            speed: 1000,
            lazyLoad: 'progressive',
            arrows: false,
            fade: true,
            dots: true,
            prevArrow: "<i class='slider-prev ba-back'></i>",
            nextArrow: "<i class='slider-next ba-next'></i>"
        });
    }

    function subscribePopup() {
        var subscribe = $('#subscribe'),
            time = subscribe.data('time');
        setTimeout(function () {
            if (subscribe.length > 0) {
                subscribe.addClass('active');
                $('body').css('overflow', 'hidden');
            }
        }, time);
        $('.ps-popup__close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.ps-popup').removeClass('active');
            $('body').css('overflow', 'auto');
        });
        $('#subscribe').on("click", function (event) {
            if (!$(event.target).closest(".ps-popup__content").length) {
                subscribe.removeClass('active');
                $("body").css('overflow-y', 'auto');
            }
        });
    }

    function stickySidebar() {
        var sticky = $('.ps-product--sticky'),
            stickySidebar, checkPoint = 992,
            windowWidth = $(window).innerWidth();
        if (sticky.length > 0) {
            stickySidebar = new StickySidebar('.ps-product__sticky .ps-product__info', {
                topSpacing: 20,
                bottomSpacing: 20,
                containerSelector: '.ps-product__sticky',
            });
            if ($('.sticky-2').length > 0) {
                var stickySidebar2 = new StickySidebar('.ps-product__sticky .sticky-2', {
                    topSpacing: 20,
                    bottomSpacing: 20,
                    containerSelector: '.ps-product__sticky',
                });
            }
            if (checkPoint > windowWidth) {
                stickySidebar.destroy();
                stickySidebar2.destroy();
            }
        } else {
            return false;
        }
    }

    function accordion() {
        var accordion = $('.ps-accordion');
        accordion.find('.ps-accordion__content').hide();
        $('.ps-accordion.active').find('.ps-accordion__content').show();
        accordion.find('.ps-accordion__header').on('click', function (e) {
            e.preventDefault();
            if ($(this).closest('.ps-accordion').hasClass('active')) {
                $(this).closest('.ps-accordion').removeClass('active');
                $(this).closest('.ps-accordion').find('.ps-accordion__content').slideUp(350);

            } else {
                $(this).closest('.ps-accordion').addClass('active');
                $(this).closest('.ps-accordion').find('.ps-accordion__content').slideDown(350);
                $(this).closest('.ps-accordion').siblings('.ps-accordion').find('.ps-accordion__content').slideUp();
            }
            $(this).closest('.ps-accordion').siblings('.ps-accordion').removeClass('active');
            $(this).closest('.ps-accordion').siblings('.ps-accordion').find('.ps-accordion__content').slideUp();
        });
    }

    function progressBar() {
        var progress = $('.ps-progress');
        progress.each(function (e) {
            var value = $(this).data('value');
            $(this).find('span').css({
                width: value + "%"
            })
        });
    }

    function customScrollbar() {
        $('.ps-custom-scrollbar').each(function () {
            var height = $(this).data('height');
            $(this).slimScroll({
                height: height + 'px',
                alwaysVisible: true,
                color: '#000000',
                size: '6px',
                railVisible: true,
            });
        })
    }

    function select2Cofig() {
        $('select.ps-select').select2({
            placeholder: $(this).data('placeholder'),
            minimumResultsForSearch: -1
        });
    }

    function carouselNavigation() {
        var prevBtn = $('.ps-carousel__prev'),
            nextBtn = $('.ps-carousel__next');
        prevBtn.on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).trigger('prev.owl.carousel', [1000]);
        });
        nextBtn.on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).trigger('next.owl.carousel', [1000]);
        });
    }

    function dateTimePicker() {
        $('.ps-datepicker').datepicker();
    }

    $(function () {
        backgroundImage();
        owlCarouselConfig();
        siteToggleAction();
        subMenuToggle();
        masonry('.ps-masonry');
        productFilterToggle();
        tabs();
        slickConfig();
        productLightbox();
        rating();
        backToTop();
        stickyHeader();
        filterSlider();
        modalInit();
        searchInit();
        countDown();
        mainSlider();
        parallax();
        stickySidebar();
        accordion();
        progressBar();
        customScrollbar();
        select2Cofig();
        carouselNavigation();
        dateTimePicker();
        $('[data-toggle="tooltip"]').tooltip();
        $('.ps-product--quickview .ps-product__images').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            dots: false,
            arrows: true,
            infinite: false,
            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
        });
    });
    $('#product-quickview').on('shown.bs.modal', function (e) {
        $('.ps-product--quickview .ps-product__images').slick('setPosition');
    });

    $(window).on('load', function () {
        $('body').addClass('loaded');
        subscribePopup();
    });

    // Live text search|| All shop
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            console.log(value);
            $("#myShop .col-md-3").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // Live text search|| Store
    $(document).ready(function () {
        $("#myStoreInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myStore").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // Live text search|| Brand
    $(document).ready(function () {
        $("#myBrandInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myBrand .ps-checkbox").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // Live text search|| Category
    $(document).ready(function () {
        $("#myCategoryInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myCategory .ps-checkbox").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    /*division select*/
    $('select.division').on('change', function () {
        var chooseDivision = $(this).children('option:selected').val();

        var url = $('.getDivisionArea').val();
        /*ajax get value*/
        if (url == null) {
            location.reload()
        } else {
            $.ajax({
                url: url,
                method: 'GET',
                data: { id: chooseDivision },
                success: function (result) {
                    $('.area').html(result);
                }
            })
        }
    });


    //get logistics
    $('.area').on('change', function () {
        var division = $('.division').val();
        var area = $(this).val();
        var url = $('.getLogistics').val();
        /*ajax get value*/
        if (url == null) {
            location.reload()
        } else {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'GET',
                data: { division: division, area: area },
                success: function (result) {
                    $('.logistics').html(result);
                }
            })
        }

    });


})(jQuery);




/*get cart items */
function cartList() {
    var url = $('.cart-list-url').val();
    if (url != null && url != undefined) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function (result) {
                localStorage.removeItem('guest_cart_items');
                let array_cart = [];
                if (result[4] == true) {
                    result[5].forEach((item => {
                        let cart_item = { vProductVS_id: item.vpvs_id, quantity: parseInt(item.quantity), campaign_id: item.campaign_id };
                        array_cart.push(cart_item);
                        localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
                    }))
                } else {
                    result[5].forEach((item => {
                        let cart_item = { vProductVS_id: item.product_stock_id, quantity: parseInt(item.quantity), campaign_id: item.campaign_id };
                        array_cart.push(cart_item);
                        localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
                    }))
                }
                guestCartList();
            },
            error: function () {
                localStorage.removeItem('guest_cart_items');
                guestCartList();
            }
        })
    }
}


function addToCart(id, campaign_id = null) {
    //db cart
    var url = $('.add-to-cart-url').val();
    if (campaign_id == null) {
        var cart_quantity = $('.cart-quantity').val();
    } else {
        var cart_quantity = $('.cart-quantity-' + id).val();
    }
    if (id != null && id != "" && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: { vProductVS_id: id, quantity: parseInt(cart_quantity), campaign_id: campaign_id },
            success: function (result) {
                if (localStorage.getItem('guest_cart_items') === null) {
                    cartList();
                }
            }
        })
    }

    //local cart
    if (id != null && id != "") {
        let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
        let array_cart = [];
        let cart_item = { vProductVS_id: id, quantity: parseInt(cart_quantity), campaign_id: campaign_id };

        if (old_cart_items != null) {
            old_cart_items.forEach(old_cart_item => {
                array_cart.push(old_cart_item);
            });
            if (array_cart.includes(array_cart.find(guest_cart_item => guest_cart_item.vProductVS_id === id))) {
                let temp_item = array_cart.find(guest_cart_item => guest_cart_item.vProductVS_id === id);
                let temp_old_cart_items = old_cart_items.filter(old_cart_item => {
                    return old_cart_item.vProductVS_id !== id;
                });
                temp_old_cart_items.push({ vProductVS_id: id, quantity: parseInt(temp_item.quantity) + 1, campaign_id: campaign_id });
                localStorage.setItem('guest_cart_items', JSON.stringify(temp_old_cart_items));
                toastr.info('Quantity has been increased', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
            else {
                array_cart.push(cart_item);
                localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
                toastr.success('Added to cart', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        } else {
            array_cart.push(cart_item);
            localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
            toastr.success('Added to cart', toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "30000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        }
        guestCartList();
    }
}

function increaseGuestCart(id) {
    let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
    let array_cart = [];
    if (old_cart_items != null) {
        old_cart_items.forEach((old_cart_item, index) => {
            if (index + 1 !== id) {
                array_cart.push(old_cart_item);
            }
            else {
                let temp_item = { vProductVS_id: old_cart_item.vProductVS_id, quantity: parseInt(old_cart_item.quantity) + 1, campaign_id: old_cart_item.campaign_id }
                array_cart.push(temp_item);
            }
        });
        localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
        toastr.info('Quantity has been increased', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
        guestCartList();
    }
}


function decreaseGuestCart(id) {
    let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
    let array_cart = [];
    if (old_cart_items != null) {
        old_cart_items.forEach((old_cart_item, index) => {
            if (index + 1 !== id) {
                array_cart.push(old_cart_item);
            }
            else {
                let temp_item = { vProductVS_id: old_cart_item.vProductVS_id, quantity: old_cart_item.quantity > 1 ? parseInt(old_cart_item.quantity) - 1 : 1, campaign_id: old_cart_item.campaign_id }
                array_cart.push(temp_item);
            }
        });
        localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
        toastr.error('Quantity has been decreased', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
        guestCartList();
    }
}


/*get cart items */
function guestCartList() {
    var url = $('.guest-cart-list-url').val();
    var empty = $('.cart-empty').val();
    var app_url = $('.app_url').val();
    var is_active_guest_checkout = $('.is-active-guest-checkout').val();

    if (url != null && url != undefined && localStorage.getItem('guest_cart_items') !== null) {
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                carts: JSON.parse(localStorage.getItem('guest_cart_items')),
            },
            success: function (result) {
                //navbar no. of carts
                $('.total_update_price').empty();
                $('.total_update_tax').empty();
                $('.total_update_total').empty();

                $('.total_update_price').append(result[1]);
                $('.total_update_tax').append(result[2]);
                $('.total_update_total').append(result[3]);

                $(".navbar-cart").empty();
                if (result[0].length == 0) {
                    $('.navbar-cart').text(0);
                } else {
                    $('.navbar-cart').text(result[0].length)
                }

                //show item in cart dropdown
                var html = "";
                var blade_html = "";

                var footer = "";
                if (result[4] == true) {
                    if (result[0].length > 0) {
                        result[0].forEach(function (item, index) {
                            $('.show-cart-items').empty();
                            $('.guest-cart-blade').empty();
                            html += '<div class="ps-product--cart-mobile">' +
                                '                               <div class="ps-product__thumbnail mt-2"><a href="' + item.url + '"><img src="' + item.img + '" alt=""></a></div>' +
                                '                               <div class="ps-product__content">' +
                                '                                   <a class="ps-product__remove" href="#!"><i class="icon-cross" onclick="deleteGuestCart(' + item.id + ')"></i></a><a href="' + item.url + '">' + item.name + '</a>' +
                                '                                  <p><strong>Sold by: </strong>' + item.shop_name + '</p>' +
                                '                                   <p><small>' + item.quantity + ' x ' + item.price + '</small></p>' +
                                '                               </div>' +
                                '                            </div>';

                            blade_html += '<tr>' +
                                '                                      <td>' +
                                '                                      <div class="ps-product--cart">' +
                                '                                          <div class="ps-product__thumbnail"><a target="_blank" href="' + item.url + '">' +
                                '                                              <img src="' + item.img + '" alt="">' +
                                '                                            </a></div>' +
                                '                                          <div class="ps-product__content">' +
                                '                                           <a href="' + item.url + '">' + item.name + '</a>' +
                                '                                           <p>Sold By:<strong>' + item.shop_name + '</strong></p>' +
                                '                                          </div>' +
                                '                                      </div>' +
                                '                                  </td>' +
                                '                                  <td class="price">' +
                                '                                       ' + item.price + ' ' +
                                '                                    </td>' +
                                '                                  <td>' +
                                '                                      <div class="form-group--number">' +
                                '                                        <span class="input-number-decrement"' +
                                '                                        onclick="decreaseGuestCart(' + item.id + ')"' +
                                '                                        data-id="{{ $cart->id }}"' +
                                '                                        >–</span>' +
                                '                                        <input id="input-number-{{ $cart->id }}" class="input-number quantity_update"' +
                                '                                        data-url="{{ route(\'update.to.cart\') }}"' +
                                '                                        type="text"' +
                                '                                        name="quantity_update"' +
                                '                                        min="1"' +
                                '                                        max="{{ $cart->stock }}"' +
                                '                                        value="' + item.quantity + '" readonly>' +
                                '                                        <span class="input-number-increment"' +
                                '                                        onclick="increaseGuestCart(' + item.id + ')"' +
                                '                                        data-id="{{ $cart->id }}"' +
                                '                                        >+</span>' +
                                '                                      </div>' +
                                '                                  </td>' +
                                '                                  <td class="updated_price-{{ $cart->id }}">' + item.blade_quantity_x_price + '</td>' +
                                '                                  <td><a href="javascript:void(0)" onclick="deleteGuestCart(' + item.id + ')"><i class="icon-cross"></i></a></td>' +
                                '                                  <tr>';
                        });
                        if (result[5] == true) {
                            $('.cart-items-footer').empty();
                            footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                '<figure><a class="ps-btn" href="' + app_url + '/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/checkout">Checkout</a></figure>'
                        }
                        else {
                            $('.cart-items-footer').empty();
                            if (is_active_guest_checkout == 'YES') {
                                footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                    '<figure><a class="ps-btn guest-view-cart" href="' + app_url + '/guest/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/guest/checkout">Guest Checkout</a></figure>'
                            }
                            else {
                                footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                    '<figure><a class="ps-btn" href="' + app_url + '/guest/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/checkout">Checkout</a></figure>'
                            }
                        }
                    } else {
                        $('.show-cart-items').empty();
                        $('.guest-cart-blade').empty();
                        $('.cart-items-footer').empty();
                        html += '<div class="ps-product--cart-mobile">' +
                            '<img src="' + empty + '" class="img-fluid" alt="empty cart"/>' +
                            '</div>';
                        footer += '<h3 class="text-center">No item in your cart</h3>'
                    }
                } else {
                    if (result[0].length > 0) {
                        result[0].forEach(function (item, index) {
                            $('.show-cart-items').empty();
                            $('.guest-cart-blade').empty();
                            html += '<div class="ps-product--cart-mobile">' +
                                '                               <div class="ps-product__thumbnail mt-2"><a href="' + item.url + '"><img src="' + item.img + '" alt=""></a></div>' +
                                '                               <div class="ps-product__content">' +
                                '                                   <a class="ps-product__remove" href="#!"><i class="icon-cross" onclick="deleteGuestCart(' + item.id + ')"></i></a><a href="' + item.url + '">' + item.name + '</a>' +
                                '                                  <p><small>' + item.quantity + ' x ' + item.price + '</small></p>' +
                                '                               </div>' +
                                '                            </div>';
                            blade_html += '<tr>' +
                                '                                      <td>' +
                                '                                      <div class="ps-product--cart">' +
                                '                                          <div class="ps-product__thumbnail"><a target="_blank" href="' + item.url + '">' +
                                '                                              <img src="' + item.img + '" alt="">' +
                                '                                            </a></div>' +
                                '                                          <div class="ps-product__content">' +
                                '                                           <a href="' + item.url + '">' + item.name + '</a>' +
                                '                                          </div>' +
                                '                                      </div>' +
                                '                                  </td>' +
                                '                                  <td class="price">' +
                                '                                       ' + item.price + ' ' +
                                '                                    </td>' +
                                '                                  <td>' +
                                '                                      <div class="form-group--number">' +
                                '                                        <span class="input-number-decrement"' +
                                '                                        onclick="decreaseGuestCart(' + item.id + ')"' +
                                '                                        data-id="{{ $cart->id }}"' +
                                '                                        >–</span>' +
                                '                                        <input id="input-number-{{ $cart->id }}" class="input-number quantity_update"' +
                                '                                        data-url="{{ route(\'update.to.cart\') }}"' +
                                '                                        type="text"' +
                                '                                        name="quantity_update"' +
                                '                                        min="1"' +
                                '                                        max="{{ $cart->stock }}"' +
                                '                                        value="' + item.quantity + '" readonly>' +
                                '                                        <span class="input-number-increment"' +
                                '                                        onclick="increaseGuestCart(' + item.id + ')"' +
                                '                                        data-id="{{ $cart->id }}"' +
                                '                                        >+</span>' +
                                '                                      </div>' +
                                '                                  </td>' +
                                '                                  <td class="updated_price-{{ $cart->id }}">' + item.blade_quantity_x_price + '</td>' +
                                '                                  <td><a href="javascript:void(0)" onclick="deleteGuestCart(' + item.id + ')"><i class="icon-cross"></i></a></td>' +
                                '                                  <tr>';
                        });

                        if (result[5] == true) {
                            $('.cart-items-footer').empty();
                            footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                '<figure><a class="ps-btn" href="' + app_url + '/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/checkout">Checkout</a></figure>'
                        }
                        else {
                            $('.cart-items-footer').empty();
                            if (is_active_guest_checkout == 'YES') {
                                footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                    '<figure><a class="ps-btn guest-view-cart" href="' + app_url + '/guest/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/guest/checkout">Guest Checkout</a></figure>'
                            }
                            else {
                                footer += '<h3>Total:<strong>' + result[1] + '</strong></h3>' +
                                    '<figure><a class="ps-btn" href="' + app_url + '/guest/shopping-cart">View Cart</a><a class="ps-btn" href="' + app_url + '/checkout">Checkout</a></figure>'
                            }
                        }
                    } else {
                        $('.show-cart-items').empty();
                        html += '<div class="ps-product--cart-mobile">' +
                            '<img src="' + empty + '" class="img-fluid" alt="empty cart"/>' +
                            '</div>';

                        $('.cart-items-footer').empty();
                        footer += '<h3 class="text-center">No item in your cart</h3>'
                    }
                }
                $(".show-cart-items").append(html)
                $(".guest-cart-blade").append(blade_html)
                $(".cart-items-footer").append(footer)
            },
            error: function () {
                localStorage.removeItem('guest_cart_items');
                guestCartList();
            }
        })
    }
    else {
        //navbar no. of carts
        $('.total_update_price').empty();
        $('.total_update_tax').empty();
        $('.total_update_total').empty();

        $('.total_update_price').text('$0.00');
        $('.total_update_tax').text('$0.00');
        $('.total_update_total').text('$0.00');
        $(".navbar-cart").empty();
        $('.navbar-cart').text(0);

        //show item in cart dropdown
        var html = "";
        var blade_html = "";
        var footer = "";
        html += '<div class="ps-product--cart-mobile">' +
            '<img src="' + empty + '" class="img-fluid" alt="empty cart"/>' +
            '</div>';
        footer += '<h3 class="text-center">No item in your cart</h3>';

        $('.show-cart-items').empty();
        $('.guest-cart-blade').empty();
        $('.cart-items-footer').empty();

        $(".show-cart-items").append(html);
        $('.guest-cart-blade').append(blade_html);
        $(".cart-items-footer").append(footer);
    }
}


//guest add to cart
function addToGuestCart(id, campaign_id = null) {
    if (campaign_id == null) {
        var cart_quantity = $('.cart-quantity').val();
    } else {
        var cart_quantity = $('.cart-quantity-' + id).val();
    }
    if (id != null && id != "") {
        let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
        let array_cart = [];
        let cart_item = { vProductVS_id: id, quantity: parseInt(cart_quantity), campaign_id: campaign_id };

        if (old_cart_items != null) {
            old_cart_items.forEach(old_cart_item => {
                array_cart.push(old_cart_item);
            });
            if (array_cart.includes(array_cart.find(guest_cart_item => guest_cart_item.vProductVS_id === id))) {

                let temp_item = array_cart.find(guest_cart_item => guest_cart_item.vProductVS_id === id);
                let temp_old_cart_items = old_cart_items.filter(old_cart_item => {
                    return old_cart_item.vProductVS_id !== id;
                });
                temp_old_cart_items.push({ vProductVS_id: id, quantity: parseInt(temp_item.quantity) + 1, campaign_id: campaign_id });
                //delete old cart items--
                localStorage.removeItem('guest_cart_items');
                localStorage.setItem('guest_cart_items', JSON.stringify(temp_old_cart_items));
                toastr.info('Quantity has been increased', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
            else {
                array_cart.push(cart_item);
                //remove old carts--
                localStorage.removeItem('guest_cart_items');
                localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
                toastr.success('Added to cart', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        } else {
            array_cart.push(cart_item);
            localStorage.setItem('guest_cart_items', JSON.stringify(array_cart));
            toastr.success('Added to cart', toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "30000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        }
    }
    guestCartList();
}
//end guest add to cart


/**
 * Cart Update
 */

// Decrement
function quantityUpdateDec(ele) {

    var url = $('.quantity_update').attr('data-url');
    var id = $(ele).attr('data-id');

    if (id != null && id != "" && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'GET',
            data: {
                idDec: id,
            },
            success: function (result) {
                //notification
                if (result.error != null) {
                    toastr.warning(result.error, toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                } else {
                    $('#input-number-' + result.quantity.id).val(result.quantity.quantity);
                    $('.updated_price-' + result.quantity.id).html(result.updated_price);

                    toastr.success(result.message, toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                }
                if (localStorage.getItem('guest_cart_items') === null) {
                    cartList();
                }
            }
        })
    } else {
        location.reload()
    }
}

// Increment
function quantityUpdateInc(ele) {
    var url = $('.quantity_update').attr('data-url');
    var id = $(ele).attr('data-id');
    var dataVal = $(ele).val();

    if (id != null && id != "" && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'GET',
            data: {
                idInc: id,
                quantity: parseInt(dataVal),
            },
            success: function (result) {
                //notification
                if (result.error != null) {
                    toastr.warning(result.error, toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                } else {
                    $('#input-number-' + result.quantity.id).val(result.quantity.quantity);
                    $('.updated_price-' + result.quantity.id).html(result.updated_price);
                    toastr.success(result.message, toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                }
                if (localStorage.getItem('guest_cart_items') === null) {
                    cartList();
                }
            }
        })
    } else {
        location.reload()
    }
}


//delete cart item
function deleteCart(cart_id) {
    var url = $('.remove-from-cart-url').val();
    if (cart_id != null && cart_id != "" && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: { id: cart_id },
            success: function (result) {
                $('#shopping_cart-' + cart_id).remove();
                cartList();
                //notification
                toastr.error(result.message, toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        })
    }
}


//delete guest cart item
function deleteGuestCart(cart_id) {
    var guest_url = $('.guest-remove-from-cart-url').val();
    if (cart_id != null && cart_id != "" && guest_url != null) {
        let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
        let delete_item = old_cart_items.filter((old_cart_item, index) => {
            return index + 1 === cart_id;
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: guest_url,
            method: 'POST',
            data: { delete_item: delete_item },
            success: function () {
                let old_cart_items = JSON.parse(localStorage.getItem('guest_cart_items'));
                let temp_old_cart_items = old_cart_items.filter((old_cart_item, index) => {
                    return index + 1 !== cart_id;
                });
                if (temp_old_cart_items.length > 0) {
                    localStorage.setItem('guest_cart_items', JSON.stringify(temp_old_cart_items));
                } else {
                    localStorage.removeItem('guest_cart_items');
                    cartList();
                }
                guestCartList();

                //notification
                toastr.error('Item has been removed', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        })
    }
}


/*get wishlist items */
function wishList() {
    var url = $('.wishlist-url').val();
    var empty = $('.wishlist-empty').val();
    var app_url = $('.app_url').val();

    if (url != null && url != undefined) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function (result) {
                //navbar no. of wishlist
                $(".navbar-wishlist").empty();
                if (result.length == 0) {
                    $('.navbar-wishlist').text(0);
                } else {
                    $('.navbar-wishlist').text(result.length);
                }

                //show item in cart dropdown
                var html = "";
                var footer = "";
                if (result.length > 0) {
                    result.forEach(function (item, index) {
                        $('.show-wishlist-items').empty();
                        $('.wishlist-items-footer').empty();
                        html += '<div class="ps-product--cart-mobile">' +
                            '                               <div class="ps-product__thumbnail mt-2"><a href="' + app_url + '/product/' + item.sku + '/' + item.slug + '"><img src="' + item.image + '" alt=""></a></div>' +
                            '                               <div class="ps-product__content">' +
                            '                                   <a class="ps-product__remove" href="#!"><i class="icon-cross" onclick="deleteWishlist(' + item.id + ')"></i></a><a href="' + app_url + '/product/' + item.sku + '/' + item.slug + '">' + item.name + '</a>' +
                            '                                  <p><strong>Price Range: </strong><span class="text-danger">' + item.range + '</span></p>' +
                            '                               </div>' +
                            '                            </div>';
                    })
                    footer += '<figure class="d-flex justify-content-center"><a class="ps-btn" href="' + app_url + '/wishlist">View Wishlist</a></figure>'
                } else {
                    $('.show-wishlist-items').empty();
                    $('.wishlist-items-footer').empty();
                    html += '<div class="ps-product--cart-mobile">' +
                        '<img src="' + empty + '" class="img-fluid" alt="empty cart"/>' +
                        '</div>';
                    footer += '<h4 class="text-center">No item in your wishlist</h4>'
                }

                $(".show-wishlist-items").append(html)
                $(".wishlist-items-footer").append(footer)
            }
        })
    }
}

//Add to wishlist
function addToWishlist(product_id) {

    try {
        event.preventDefault();
    } catch (e) {

    }
    var url = $('.add-to-wishlist-url').val();

    if (product_id != null && product_id != "" && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: { product_id: product_id },
            success: function (result) {
                //notification
                toastr.success(result.message, toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                var is_auth = $('.auth-check').val();
                if (is_auth == 1) {
                    wishList();
                }
            }
        })
    }
}

//Go To Auth
function goToAuth() {
    event.preventDefault();
    var goAuth = $('.go-to-auth').val();
    window.location = goAuth;
}

//delete wishlist item
function deleteWishlist(wishlist_id) {
    var url = $('.remove-from-wishlist-url').val();
    if (wishlist_id != null && wishlist_id != null && url != null) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: { id: wishlist_id },
            success: function (result) {
                //notification
                toastr.error(result.message, toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                var is_auth = $('.auth-check').val();
                if (is_auth == 1) {
                    wishList();
                }
            }
        });

        localStorage.removeItem('wish_list');
    } else {
        location.reload()
    }
}

/*get compare items */
function compareList() {
    var url = $('.compare-list-url').val();
    var empty = $('.compare-empty').val();
    var app_url = $('.app_url').val();

    var product_items = JSON.parse(localStorage.getItem('compare_products'));
    var product_items_for_web = localStorage.getItem('compare_products');
    if (url != null && url != undefined) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: { products: product_items },
            success: function (result) {
                //navbar no. of comparison
                $(".navbar-comparison").empty();
                if (result.length == 0) {
                    $('.navbar-comparison').text(0);
                } else {
                    $('.navbar-comparison').text(result.length);
                }
                //show item in cart dropdown
                var html = "";
                var footer = "";
                if (result.length > 0) {
                    result.forEach(function (item, index) {
                        $('.show-comparison-items').empty();
                        $('.comparison-items-footer').empty();
                        html += '<div class="ps-product--cart-mobile">' +
                            '                               <div class="ps-product__thumbnail mt-2"><a href="' + app_url + '/product/' + item.sku + '/' + item.slug + '"><img src="' + app_url + '/public/' + item.image + '" alt=""></a></div>' +
                            '                               <div class="ps-product__content">' +
                            '                                   <a class="ps-product__remove" href="#!"><i class="icon-cross" onclick="deleteCompare(' + item.id + ')"></i></a><a href="' + app_url + '/product/' + item.sku + '/' + item.slug + '">' + item.name + '</a>' +
                            '                                  <p><strong>Price Range: </strong><span class="text-danger">' + item.range + '</span></p>' +
                            '                               </div>' +
                            '                            </div>';
                    })
                    footer += '<figure class="d-flex justify-content-center">' +
                        '<form action="' + app_url + '/comparison">' +
                        '<input type="hidden" name="products[]" value="' + product_items_for_web + '">' +
                        '<button class="ps-btn" type="submit">Compare</button>' +
                        '</form>' +
                        '</figure>'
                } else {
                    $('.show-comparison-items').empty();
                    $('.comparison-items-footer').empty();
                    html += '<div class="ps-product--cart-mobile">' +
                        '<img src="' + empty + '" class="img-fluid" alt="empty caomparison"/>' +
                        '</div>';
                    footer += '<h3 class="text-center">No item for comparison</h3>'
                }

                $(".show-comparison-items").append(html)
                $(".comparison-items-footer").append(footer)
            }
        })
    }
}

//Add to compare
function addToCompare(product_id) {
    event.preventDefault();
    if (product_id != null) {
        let old_items = JSON.parse(localStorage.getItem('compare_products'));
        if (old_items != null) {
            if (old_items.length > 2) {
                toastr.error('You have reached maximum number of products to compare at once.', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else {
                let array_compare = [];
                old_items.forEach(old_item => {
                    array_compare.push(old_item);
                });
                if (array_compare.includes(product_id)) {
                    toastr.error('Item already exist in comparison', toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                } else {
                    array_compare.push(product_id);
                    localStorage.removeItem('compare_products');
                    localStorage.setItem('compare_products', JSON.stringify(array_compare));
                    toastr.success('Added for comparison', toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "30000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                }
            }
        } else {
            let array_compare = [product_id];
            localStorage.setItem('compare_products', JSON.stringify(array_compare));
            toastr.success('Added for comparison', toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "30000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        }
        compareList();
    } else {
        location.reload()
    }
}

//delete compare item
function deleteCompare(product_id) {
    var app_url = $('.app_url').val();
    let old_items = JSON.parse(localStorage.getItem('compare_products'));
    if (product_id != null) {
        let array_compare = [];
        old_items.forEach(old_item => {
            if (old_item != product_id) {
                array_compare.push(old_item);
            }
        });
        localStorage.removeItem('compare_products');
        localStorage.setItem('compare_products', JSON.stringify(array_compare));
        compareList();
        toastr.error('Item removed from comparison', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });

    } else {
        location.reload()
    }
}

// myLogistic
function myLogistic(ele) {
    var url = $('.logistic_url').val();
    var dataID = $(ele).attr('data-id');
    var logisticId = $(ele).attr('data-logisticId');
    var shipping_id = '#' + dataID;
    var shipping_amount = $(shipping_id).val();
    var amount = $('.amount').val();
    var forLogisticsAmount = $('.forLogisticsAmount').val();

    $('.get_logistic_id').val(logisticId);
    $('.get_shipping_value').val(shipping_amount);

    /*ajax get value*/
    if (url == null) {
        location.reload()
    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                shipping_amount: shipping_amount,
                amount: amount,
                forLogisticsAmount: forLogisticsAmount
            },
            success: function (result) {

                $('.newTotal').html(result.data);
                $('.newTotalHidden').val(result.data);
                $('.newTotalWithOutFormat').val(result.data2);

                toastr.success('Amount calculated', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        })
    }

}


// myLogistic
function getVendor(ele) {
    var url = $('.color_url').val();
    var variant_id = $(ele).attr('data-id');
    var product_id = $(ele).attr('data-product');

    /*ajax get value*/
    if (url == null) {
        location.reload()
    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'GET',
            data: { variant_id: variant_id, product_id: product_id },
            success: function (result) {
                $('.newTotal').html(result.data);

                toastr.success(result.message, toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-left",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });

            }
        })
    }

}

// Prince
//show the modal in this function
function quickView(url) {
    $('#product-quickview').modal('show');
    $('#product-quickview').load(url);
}


function forModal(url, message) {
    event.preventDefault();
    $("#show-modal").modal("show");
    // $("#show-modal").dialog( "open" );
    $("#title").text(message);
    $("#show-form").load(url);
    $("body").on("shown.bs.modal", ".modal", function () {
        $(this)
            .find("select")
            .each(function () {
                var dropdownParent = $(document.body);
                if ($(this).parents(".modal.in:first").length !== 0)
                    dropdownParent = $(this).parents(".modal.in:first");
                $(this).select2({
                    dropdownParent: dropdownParent,
                    templateResult: formatState,
                    templateSelection: formatState,
                });
            });
    });
}

/**
 * Smooth scroll
 */
$(document).ready(function () {
    // Add smooth scrolling to all links
    $("#check_shop").on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
});


/**
 * Sub Total
 */
$(document).ready(function () {
    if (localStorage.getItem('guest_cart_items') === null) {
        cartList();
    }
    var is_auth = $('.auth-check').val();
    if (is_auth == 1) {
        wishList();
    }
    compareList();
    var sub_total = $('#sub_total').val();
    $('#coupon_sub_total').val(sub_total);
});

/**
 * Track Order
 */
function trackOrder(e) {

    $("#trackForm").on('submit', function () {
        e.preventDefault();
    });

    var url = $('#url').val();
    var order_number = $('#order_number').val();
    var email = $('#email').val();


    /**
     * Ajax Request Header setup
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Submit form data using ajax
     */

    $('#loading').html('Tracking Order....');

    $.ajax({
        url: url,
        method: 'GET',
        data: {
            order_number: order_number,
            email: email
        },
        success: function (response) {
            console.clear();
            $('#loading').addClass('d-none');
            $('#noResult').empty();
            $('#trackResult').empty();
            if (response.logistic != null) {

                var status = response.status;
                // confirmed
                if (status == 'confirmed') {
                    var confirmed = 'completed';
                }
                // processing
                if (status == 'processing') {
                    var processing = 'completed';
                }
                // quality_check
                if (status == 'quality_check') {
                    var quality_check = 'completed';
                }
                // product_dispatched
                if (status == 'product_dispatched') {
                    var product_dispatched = 'completed';
                }
                // delivered
                if (status == 'delivered') {
                    var delivered = 'completed';
                }

                $('#trackResult').html(
                    '<div class="container padding-bottom-3x mb-1">\n' +
                    '        <div class="card mb-3">\n' +
                    '          <div class="p-4 text-center text-white text-lg bg-dark rounded-top"><span class="text-uppercase">Tracking Order No - </span><span class="text-medium">' + '#' + response.booking_code + '</span></div>\n' +
                    '          <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">\n' +
                    '            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped Via:</span> ' + response.logistic.name + ' </div>\n' +
                    '            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span> ' + response.status + ' </div>\n' +
                    '          </div>\n' +
                    '          <div class="card-body">\n' +
                    '            <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">\n' +
                    '              <div class="step ' + confirmed + ' ' + processing + ' ' + quality_check + ' ' + product_dispatched + ' ' + delivered + '">\n' +
                    '                <div class="step-icon-wrap">\n' +
                    '                  <div class="step-icon"><i class="icon-check"></i></div>\n' +
                    '                </div>\n' +
                    '                <h4 class="step-title">Confirmed Order</h4>\n' +
                    '              </div>\n' +
                    '              <div class="step ' + processing + ' ' + quality_check + ' ' + product_dispatched + ' ' + delivered + ' ">\n' +
                    '                <div class="step-icon-wrap">\n' +
                    '                  <div class="step-icon"><i class="icon-ticket"></i></div>\n' +
                    '                </div>\n' +
                    '                <h4 class="step-title">Processing Order</h4>\n' +
                    '              </div>\n' +
                    '              <div class="step ' + quality_check + ' ' + product_dispatched + ' ' + delivered + ' ">\n' +
                    '                <div class="step-icon-wrap">\n' +
                    '                  <div class="step-icon"><i class="icon-thumbs-up"></i></div>\n' +
                    '                </div>\n' +
                    '                <h4 class="step-title">Quality Checked</h4>\n' +
                    '              </div>\n' +
                    '              <div class="step ' + product_dispatched + ' ' + delivered + ' ">\n' +
                    '                <div class="step-icon-wrap">\n' +
                    '                  <div class="step-icon"><i class="icon-truck"></i></div>\n' +
                    '                </div>\n' +
                    '                <h4 class="step-title">Product Dispatched</h4>\n' +
                    '              </div>\n' +
                    '              <div class="step ' + delivered + ' ">\n' +
                    '                <div class="step-icon-wrap">\n' +
                    '                  <div class="step-icon"><i class="icon-gift"></i></div>\n' +
                    '                </div>\n' +
                    '                <h4 class="step-title">Product Delivered</h4>\n' +
                    '              </div>\n' +
                    '            </div>\n' +
                    '          </div>\n' +
                    '        </div>'
                );
            } else {
                $('#noResult').html('<h3 class="text-center">No Order Found</h3>');
            }


        }
    });
}

// Self-executing function
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


/**
 * FILTER
 */

$(document).ready(function () {
    $('#sort_filter').on('change', function () {
        $('#sort_form').submit();
    });

});



// increament decreament
function increaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 1 : value;
    value++;
    document.getElementById('number').value = value;
}

function decreaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 1 : value;
    value < 1 ? value = 1 : '';
    value--;
    if (value <= 0) {
        value = 1;
    }
    document.getElementById('number').value = value;
}

// increment decrement
function increaseValueCamp(ele) {
    var increaseMax = $('#number' + ele.id).attr('data-max');
    var id_value = $('#number' + ele.id).val();
    var valueInc = parseInt(id_value, increaseMax);
    valueInc = isNaN(valueInc) ? 1 : valueInc;
    if (increaseMax <= valueInc) {
        valueInc == increaseMax;
    }
    else {
        valueInc++;
    }
    document.getElementById('number' + ele.id).value = valueInc;
}

function decreaseValueCamp(ele) {
    var value = parseInt(document.getElementById('number' + ele.id).value, 10);
    value = isNaN(value) ? 1 : value;
    value < 1 ? value = 1 : value;
    value--;
    if (value <= 0) {
        value = 1;
    }
    document.getElementById('number' + ele.id).value = value;
}

/**
 * COOKIES FOR MODAL
 */

window.setTimeout(function () {
    // First check, if localStorage is supported.
    if (window.localStorage) {
        // Get the expiration date of the previous popup.
        var nextPopup = localStorage.getItem('subscribeModal-lg');

        if (nextPopup > new Date()) {
            return;
        }

        // Store the expiration date of the current popup in localStorage.
        var expires = new Date();
        expires = expires.setHours(expires.getHours() + 24);

        localStorage.setItem('subscribeModal-lg', expires);
    }

    $('.subscribeModal-lg').modal('show');
}, 1000);


$(document).ready(function () {
    setInterval(function () {
        localStorage.removeItem('subscribeModal-lg');
    }, 3600000);
});


var TxtType = function (el, toRotate, period) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
};

TxtType.prototype.tick = function () {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

    var that = this;
    var delta = 200 - Math.random() * 100;

    if (this.isDeleting) {
        delta /= 2;
    }

    if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
    }

    setTimeout(function () {
        that.tick();
    }, delta);
};





function pushToStorage(arr) {
    if (typeof (Storage) !== "undefined") {

        localStorage.setItem("wish_list", JSON.stringify(arr));
    } else {
        console.log("your browser does not support Storage");
    }
}


function pushToStorageWishID(arr) {
    if (typeof (Storage) !== "undefined") {
        localStorage.setItem("wish_id", JSON.stringify(arr));
    } else {
        console.log("your browser does not support Storage");
    }
}

function loadExisting() {
    var stored_wishList = JSON.parse(localStorage.getItem("wish_list"));
    if (stored_wishList != null) {
        wish_list = stored_wishList;
        $("#show-wishlist-items").empty();
        $(".show-all-wishlist").empty();
        stored_wishList.forEach(function (item, index, arr) {
            $("#show-wishlist-items").append(item);
            $(".show-all-wishlist").append(item);
        });
        count_items_in_wishlist_update();
    }else{
        /*here the  image*/
    }
}

$(document).ready(function () {
    loadExisting();
    count_items_in_wishlist_update();
    $(".wishlist").on("click", function (e) {
        e.preventDefault()
        var data = "";
        var product_id = $(this).attr("data-product_id");
        var product_name = $(this).attr("data-product_name");
        var product_price = $(this).attr("data-product_price");
        var product_sku = $(this).attr("data-product_sku");
        var product_slug = $(this).attr("data-product_slug");
        var product_image = $(this).attr("data-product_image");
        var app_url = $(this).attr("data-app_url");
        //check if the element is in the array
        if ($.inArray(product_id, wish_list) == -1) {
            if (productId.indexOf(product_id) < 0) {
                var last_id = wish_list.length == 0 ? 0 : wish_list.length;

                var product_str = '<div class="ps-product--cart-mobile p-' + product_id + '" id="list_id_' + last_id + '">' +
                    '<input type="hidden" class="list_id_' + last_id + '" value="' + product_id + '">' +
                    '                               <div class="ps-product__thumbnail mt-2"><a href="' + app_url + '/product/' + product_sku + '/' + product_slug + '"><img src="' + product_image + '" alt=""></a></div>' +
                    '                               <div class="ps-product__content">' +
                    '                                   <a class="ps-product__remove w-premove" wpid="' + last_id + '" href="#!"><i class="icon-cross"></i></a><a href="' + app_url + '/product/' + product_sku + '/' + product_slug + '">' + product_name + '</a>' +
                    '                                  <p><strong>Price Range: </strong><span class="text-danger">' + product_price + '</span></p>' +
                    '                               </div>' +
                    '                            </div>';

                $("#show-wishlist-items").append(product_str);
                $(".show-all-wishlist").append(product_str);

                wish_list.push(product_str);
                pushToStorage(wish_list);
                productId.push(product_id) //this is for check the product id in array
                pushToStorageWishID(productId);
                count_items_in_wishlist_update();
                $("#show-wishlist-items").empty();
                $(".show-all-wishlist").empty();
                loadExisting();


                //notification
                toastr.success('Added To Wishlist', toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "30000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });

            }

        }



    });


    $("#show-wishlist-items").on("click", ".w-premove", function () {
        var array_index = parseInt($(this).attr("wpid"));
        $("#list_id_" + array_index).remove();
        delete wish_list[array_index];
        localStorage.removeItem("wish_list");
        pushToStorage(wish_list);
        count_items_in_wishlist_update();
        $("#show-wishlist-items").empty();
        loadExisting();

        toastr.error('Removed From Wishlist', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });


    });


    $(".show-all-wishlist").on("click", ".w-premove", function () {
        var array_index = parseInt($(this).attr("wpid"));
        $("#list_id_" + array_index).remove();
        delete wish_list[array_index];
        localStorage.removeItem("wish_list");
        pushToStorage(wish_list);
        count_items_in_wishlist_update();
        $(".show-all-wishlist").empty();
        loadExisting();


        toastr.error('Removed From Wishlist', toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "30000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });


    });



});

//Validation against the amount of product being added
var count_wishlist = 0;
function count_items_in_wishlist_update() {
    count_wishlist = 0;
    var stored_wishList = JSON.parse(localStorage.getItem("wish_list"));
    console.log(stored_wishList);
    wish_list.forEach(countFunc)
    $("#listitem").html(count_wishlist);

    // empty wishlist image
    var empty_wishlist_img = $('.empty_wishlist_img').val();
    var wishlists_url = $('.wishlists-index').val();

    if (count_wishlist == 0) {
        $("#show-wishlist-items").html('<img src="' + empty_wishlist_img + '" class="img-fluid" alt="empty cart"/>');
        $(".show-all-wishlist").html('<img src="' + empty_wishlist_img + '" class="img-fluid" alt="empty cart"/>');
    } else {
        $("#show-all-wishlist").empty();
        $("#show-all-wishlist").html('<a href="' + wishlists_url + '" class="btn btn-white f-s-16 bg-white">Show All Wishlist</a>');
    }

}
function countFunc(item, index) {
    if (item != null) {
        count_wishlist++;
    }
}

/**
 * Store Wishlist Data At Auth
 */


$(document).ready(function () {
    var stored_wishList = JSON.parse(localStorage.getItem("wish_list"));
    console.log(typeof stored_wishList);
    const values = Object.values(stored_wishList);

    if (values != null) {
        values.forEach(addTOWishlistInAuth);
        localStorage.removeItem('wish_id');
    }

})

function addTOWishlistInAuth(item, index) {

    var auth_check = $('.auth-check').val();
    if (auth_check == 1) {
        var t = $(".list_id_" + index).val();
        addToWishlist(t);
        localStorage.removeItem('wish_list');
    }

}



