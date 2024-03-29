/*
 Highcharts JS v7.2.1 (2019-10-31)

 Accessibility module

 (c) 2010-2019 Highsoft AS
 Author: Oystein Moseng

 License: www.highcharts.com/license
 */
(function (e) {
    "object" === typeof module && module.exports ? (e["default"] = e, module.exports = e) : "function" === typeof define && define.amd ? define("highcharts/modules/accessibility", ["highcharts"], function (p) {
        e(p);
        e.Highcharts = p;
        return e
    }) : e("undefined" !== typeof Highcharts ? Highcharts : void 0)
})(function (e) {
    function p(d, e, k, l) {
        d.hasOwnProperty(e) || (d[e] = l.apply(null, k))
    }

    e = e ? e._modules : {};
    p(e, "modules/accessibility/KeyboardNavigationHandler.js", [e["parts/Globals.js"]], function (d) {
        function e(d, a) {
            this.chart = d;
            this.keyCodeMap =
                a.keyCodeMap || [];
            this.validate = a.validate;
            this.init = a.init;
            this.terminate = a.terminate;
            this.response = {success: 1, prev: 2, next: 3, noHandler: 4, fail: 5}
        }

        var k = d.find;
        e.prototype = {
            run: function (d) {
                var a = d.which || d.keyCode, c = this.response.noHandler, f = k(this.keyCodeMap, function (c) {
                    return -1 < c[0].indexOf(a)
                });
                f ? c = f[1].call(this, a, d) : 9 === a ? c = this.response[d.shiftKey ? "prev" : "next"] : 27 === a && (this.chart && this.chart.tooltip && this.chart.tooltip.hide(0), c = this.response.success);
                return c
            }
        };
        return e
    });
    p(e, "modules/accessibility/AccessibilityComponent.js",
        [e["parts/Globals.js"], e["parts/Utilities.js"]], function (d, e) {
            function u() {
            }

            var l = e.extend, a = e.pick, c = d.win, f = c.document, g = d.merge, b = d.addEvent;
            u.prototype = {
                initBase: function (a) {
                    this.chart = a;
                    this.eventRemovers = [];
                    this.domElements = [];
                    this.keyCodes = {left: 37, right: 39, up: 38, down: 40, enter: 13, space: 32, esc: 27, tab: 9};
                    this.hiddenStyle = {position: "absolute", width: "1px", height: "1px", overflow: "hidden"}
                }, addEvent: function () {
                    var a = d.addEvent.apply(d, arguments);
                    this.eventRemovers.push(a);
                    return a
                }, createElement: function () {
                    var a =
                        d.win.document.createElement.apply(d.win.document, arguments);
                    this.domElements.push(a);
                    return a
                }, fakeClickEvent: function (a) {
                    if (a && a.onclick && f.createEvent) {
                        var b = f.createEvent("Event");
                        b.initEvent("click", !0, !1);
                        a.onclick(b)
                    }
                }, addProxyGroup: function (a) {
                    this.createOrUpdateProxyContainer();
                    var b = this.createElement("div");
                    Object.keys(a || {}).forEach(function (c) {
                        null !== a[c] && b.setAttribute(c, a[c])
                    });
                    this.chart.a11yProxyContainer.appendChild(b);
                    return b
                }, createOrUpdateProxyContainer: function () {
                    var a = this.chart,
                        b = a.renderer.box;
                    a.a11yProxyContainer = a.a11yProxyContainer || this.createProxyContainerElement();
                    b.nextSibling !== a.a11yProxyContainer && a.container.insertBefore(a.a11yProxyContainer, b.nextSibling)
                }, createProxyContainerElement: function () {
                    var a = f.createElement("div");
                    a.className = "highcharts-a11y-proxy-container";
                    return a
                }, createProxyButton: function (a, c, f, d, h) {
                    var r = a.element, n = this.createElement("button"),
                        m = g({"aria-label": r.getAttribute("aria-label")}, f);
                    a = this.getElementPosition(d || a);
                    Object.keys(m).forEach(function (a) {
                        null !==
                        m[a] && n.setAttribute(a, m[a])
                    });
                    n.className = "highcharts-a11y-proxy-button";
                    h && b(n, "click", h);
                    this.setProxyButtonStyle(n, a);
                    this.proxyMouseEventsForButton(r, n);
                    c.appendChild(n);
                    m["aria-hidden"] || this.unhideElementFromScreenReaders(n);
                    return n
                }, getElementPosition: function (a) {
                    var b = a.element;
                    return (a = this.chart.renderTo) && b && b.getBoundingClientRect ? (b = b.getBoundingClientRect(), a = a.getBoundingClientRect(), {
                        x: b.left - a.left,
                        y: b.top - a.top,
                        width: b.right - b.left,
                        height: b.bottom - b.top
                    }) : {x: 0, y: 0, width: 1, height: 1}
                },
                setProxyButtonStyle: function (b, c) {
                    g(!0, b.style, {
                        "border-width": 0,
                        "background-color": "transparent",
                        cursor: "pointer",
                        outline: "none",
                        opacity: .001,
                        filter: "alpha(opacity=1)",
                        "-ms-filter": "progid:DXImageTransform.Microsoft.Alpha(Opacity=1)",
                        zIndex: 999,
                        overflow: "hidden",
                        padding: 0,
                        margin: 0,
                        display: "block",
                        position: "absolute",
                        width: (c.width || 1) + "px",
                        height: (c.height || 1) + "px",
                        left: a(c.x, c.left) + "px",
                        top: a(c.y, c.top) + "px"
                    })
                }, proxyMouseEventsForButton: function (a, c) {
                    var f = this;
                    ["click", "mouseover", "mouseenter",
                        "mouseleave", "mouseout"].forEach(function (g) {
                        b(c, g, function (b) {
                            var h = f.cloneMouseEvent(b);
                            if (a)if (h) a.fireEvent ? a.fireEvent(h) : a.dispatchEvent && a.dispatchEvent(h); else if (a["on" + g]) a["on" + g](b);
                            b.stopPropagation();
                            b.preventDefault()
                        })
                    })
                }, cloneMouseEvent: function (a) {
                    if ("function" === typeof c.MouseEvent)return new c.MouseEvent(a.type, a);
                    if (f.createEvent) {
                        var b = f.createEvent("MouseEvent");
                        if (b.initMouseEvent)return b.initMouseEvent(a.type, "click" === a.type || a.canBubble, a.cancelable, a.view, a.detail, a.screenX,
                            a.screenY, a.clientX, a.clientY, a.ctrlKey, a.altKey, a.shiftKey, a.metaKey, a.button, a.relatedTarget), b;
                        b = f.createEvent("Event");
                        if (b.initEvent)return b.initEvent(a.type, !0, !0), b
                    }
                }, removeElement: function (a) {
                    a && a.parentNode && a.parentNode.removeChild(a)
                }, unhideElementFromScreenReaders: function (a) {
                    a.setAttribute("aria-hidden", !1);
                    a !== this.chart.renderTo && a.parentNode && (Array.prototype.forEach.call(a.parentNode.childNodes, function (a) {
                        a.hasAttribute("aria-hidden") || a.setAttribute("aria-hidden", !0)
                    }), this.unhideElementFromScreenReaders(a.parentNode))
                },
                destroyBase: function () {
                    var a = this;
                    this.removeElement((this.chart || {}).a11yProxyContainer);
                    this.eventRemovers.forEach(function (a) {
                        a()
                    });
                    this.domElements.forEach(function (b) {
                        a.removeElement(b)
                    });
                    this.eventRemovers = [];
                    this.domElements = []
                }
            };
            l(u.prototype, {
                init: function () {
                }, getKeyboardNavigation: function () {
                }, onChartUpdate: function () {
                }, onChartRender: function () {
                }, destroy: function () {
                }
            });
            return u
        });
    p(e, "modules/accessibility/KeyboardNavigation.js", [e["parts/Globals.js"], e["modules/accessibility/KeyboardNavigationHandler.js"]],
        function (d, e) {
            function u(a, b, c) {
                this.init(a, b, c)
            }

            var l = d.merge, a = d.addEvent, c = d.win, f = c.document;
            u.prototype = {
                init: function (c, b) {
                    var g = this;
                    this.chart = c;
                    this.components = b;
                    this.modules = [];
                    this.currentModuleIx = 0;
                    c.container.hasAttribute("tabIndex") || c.container.setAttribute("tabindex", "0");
                    this.addExitAnchor();
                    this.unbindKeydownHandler = a(c.renderTo, "keydown", function (a) {
                        g.onKeydown(a)
                    });
                    this.unbindMouseUpHandler = a(f, "mouseup", function () {
                        g.onMouseUp()
                    });
                    this.update();
                    this.modules.length && this.modules[0].init(1)
                },
                update: function (a) {
                    var b = this.chart.options.accessibility;
                    b = b && b.keyboardNavigation;
                    var c = this.components;
                    b && b.enabled && a && a.length ? this.modules = a.reduce(function (a, b) {
                        b = c[b].getKeyboardNavigation();
                        return b.length ? a.concat(b) : (a.push(b), a)
                    }, [new e(this.chart, {})]) : (this.modules = [], this.currentModuleIx = 0)
                }, onMouseUp: function () {
                    if (!(this.keyboardReset || this.chart.pointer && this.chart.pointer.chartPosition)) {
                        var a = this.chart, b = this.modules && this.modules[this.currentModuleIx || 0];
                        b && b.terminate && b.terminate();
                        a.focusElement && a.focusElement.removeFocusBorder();
                        this.currentModuleIx = 0;
                        this.keyboardReset = !0
                    }
                }, onKeydown: function (a) {
                    a = a || c.event;
                    var b, f = this.modules && this.modules.length && this.modules[this.currentModuleIx];
                    this.keyboardReset = !1;
                    if (f) {
                        var g = f.run(a);
                        g === f.response.success ? b = !0 : g === f.response.prev ? b = this.prev() : g === f.response.next && (b = this.next());
                        b && a.preventDefault()
                    }
                }, prev: function () {
                    return this.move(-1)
                }, next: function () {
                    return this.move(1)
                }, move: function (a) {
                    var b = this.modules && this.modules[this.currentModuleIx];
                    b && b.terminate && b.terminate(a);
                    this.chart.focusElement && this.chart.focusElement.removeFocusBorder();
                    this.currentModuleIx += a;
                    if (b = this.modules && this.modules[this.currentModuleIx]) {
                        if (b.validate && !b.validate())return this.move(a);
                        if (b.init)return b.init(a), !0
                    }
                    this.currentModuleIx = 0;
                    0 < a ? (this.exiting = !0, this.exitAnchor.focus()) : this.chart.renderTo.focus();
                    return !1
                }, addExitAnchor: function () {
                    var g = this.chart, b = this.exitAnchorWrapper = f.createElement("div"),
                        d = this.exitAnchor = f.createElement("h6"), m = this,
                        e = g.langFormat("accessibility.svgContainerEnd", {chart: g});
                    d.innerHTML = e;
                    b.setAttribute("aria-hidden", "false");
                    b.setAttribute("class", "highcharts-exit-anchor-wrapper");
                    b.style.position = "relative";
                    b.style.outline = "none";
                    d.setAttribute("tabindex", "0");
                    d.setAttribute("aria-hidden", !1);
                    l(!0, d.style, {
                        position: "absolute",
                        width: "1px",
                        height: "1px",
                        bottom: "5px",
                        zIndex: 0,
                        overflow: "hidden",
                        outline: "none"
                    });
                    b.appendChild(d);
                    g.renderTo.appendChild(b);
                    this.unbindExitAnchorUpdate = a(g, "render", function () {
                        this.renderTo.appendChild(b)
                    });
                    this.unbindExitAnchorFocus = a(d, "focus", function (a) {
                        a = a || c.event;
                        m.exiting ? m.exiting = !1 : (g.renderTo.focus(), a.preventDefault(), m.modules && m.modules.length && (m.currentModuleIx = m.modules.length - 1, (a = m.modules[m.currentModuleIx]) && a.validate && !a.validate() ? m.prev() : a && a.init(-1)))
                    })
                }, destroy: function () {
                    this.unbindExitAnchorFocus && (this.unbindExitAnchorFocus(), delete this.unbindExitAnchorFocus);
                    this.unbindExitAnchorUpdate && (this.unbindExitAnchorUpdate(), delete this.unbindExitAnchorUpdate);
                    this.exitAnchorWrapper &&
                    this.exitAnchorWrapper.parentNode && (this.exitAnchorWrapper.parentNode.removeChild(this.exitAnchorWrapper), delete this.exitAnchor, delete this.exitAnchorWrapper);
                    this.unbindKeydownHandler && this.unbindKeydownHandler();
                    this.unbindMouseUpHandler && this.unbindMouseUpHandler()
                }
            };
            return u
        });
    p(e, "modules/accessibility/utilities.js", [], function () {
        function d(d) {
            return d.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#x27;").replace(/\//g, "&#x2F;")
        }

        return {
            stripHTMLTagsFromString: function (d) {
                return "string" ===
                typeof d ? d.replace(/<\/?[^>]+(>|$)/g, "") : d
            }, makeHTMLTagFromText: function (e, k) {
                return "<" + e + ">" + d(k) + "</" + e + ">"
            }, escapeStringForHTML: d
        }
    });
    p(e, "modules/accessibility/components/LegendComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigationHandler.js"], e["modules/accessibility/utilities.js"]], function (d, e, k, l, a) {
        e = e.extend;
        var c = a.stripHTMLTagsFromString;
        d.Chart.prototype.highlightLegendItem = function (a) {
            var c =
                this.legend.allItems, b = this.highlightedLegendItemIx;
            return c[a] ? (c[b] && d.fireEvent(c[b].legendGroup.element, "mouseout"), void 0 !== c[a].pageIx && c[a].pageIx + 1 !== this.legend.currentPage && this.legend.scroll(1 + c[a].pageIx - this.legend.currentPage), this.setFocusToElement(c[a].legendItem, c[a].a11yProxyElement), d.fireEvent(c[a].legendGroup.element, "mouseover"), !0) : !1
        };
        d.addEvent(d.Legend, "afterColorizeItem", function (a) {
            var c = a.item;
            this.chart.options.accessibility.enabled && c && c.a11yProxyElement && c.a11yProxyElement.setAttribute("aria-pressed",
                a.visible ? "false" : "true")
        });
        a = function () {
        };
        a.prototype = new k;
        e(a.prototype, {
            onChartRender: function () {
                var a = this.chart, g = a.options.accessibility, b = a.legend && a.legend.allItems, d = this;
                d.legendProxyButtonClicked ? delete d.legendProxyButtonClicked : (this.removeElement(this.legendProxyGroup), !b || !b.length || a.colorAxis && a.colorAxis.length || !a.options.legend.accessibility.enabled || (this.legendProxyGroup = this.addProxyGroup({
                    "aria-label": a.langFormat("accessibility.legendLabel"), role: "all" === g.landmarkVerbosity ?
                        "region" : null
                }), b.forEach(function (b) {
                    b.legendItem && b.legendItem.element && (b.a11yProxyElement = d.createProxyButton(b.legendItem, d.legendProxyGroup, {
                        tabindex: -1,
                        "aria-pressed": !b.visible,
                        "aria-label": a.langFormat("accessibility.legendItem", {chart: a, itemName: c(b.name)})
                    }, b.legendGroup.div ? b.legendItem : b.legendGroup, function () {
                        d.legendProxyButtonClicked = !0
                    }))
                })))
            }, getKeyboardNavigation: function () {
                var a = this.keyCodes, c = this, b = this.chart, e = b.options.accessibility;
                return new l(b, {
                    keyCodeMap: [[[a.left, a.right,
                        a.up, a.down], function (f) {
                        f = f === a.left || f === a.up ? -1 : 1;
                        return b.highlightLegendItem(c.highlightedLegendItemIx + f) ? (c.highlightedLegendItemIx += f, this.response.success) : 1 < b.legend.allItems.length && e.keyboardNavigation.wrapAround ? (this.init(f), this.response.success) : this.response[0 < f ? "next" : "prev"]
                    }], [[a.enter, a.space], function () {
                        var a = b.legend.allItems[c.highlightedLegendItemIx];
                        a && a.a11yProxyElement && d.fireEvent(a.a11yProxyElement, "click");
                        return this.response.success
                    }]], validate: function () {
                        var a = b.options.legend;
                        return b.legend && b.legend.allItems && b.legend.display && !(b.colorAxis && b.colorAxis.length) && a && a.accessibility && a.accessibility.enabled && a.accessibility.keyboardNavigation && a.accessibility.keyboardNavigation.enabled
                    }, init: function (a) {
                        a = 0 < a ? 0 : b.legend.allItems.length - 1;
                        b.highlightLegendItem(a);
                        c.highlightedLegendItemIx = a
                    }
                })
            }
        });
        return a
    });
    p(e, "modules/accessibility/components/MenuComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigationHandler.js"]],
        function (d, e, k, l) {
            e = e.extend;
            d.Chart.prototype.showExportMenu = function () {
                this.exportSVGElements && this.exportSVGElements[0] && (this.exportSVGElements[0].element.onclick(), this.highlightExportItem(0))
            };
            d.Chart.prototype.hideExportMenu = function () {
                var a = this.exportDivElements;
                a && this.exportContextMenu && (a.forEach(function (a) {
                    if ("highcharts-menu-item" === a.className && a.onmouseout) a.onmouseout()
                }), this.highlightedExportItemIx = 0, this.exportContextMenu.hideMenu(), this.container.focus())
            };
            d.Chart.prototype.highlightExportItem =
                function (a) {
                    var c = this.exportDivElements && this.exportDivElements[a],
                        f = this.exportDivElements && this.exportDivElements[this.highlightedExportItemIx];
                    if (c && "DIV" === c.tagName && (!c.children || !c.children.length)) {
                        var d = !!(this.renderTo.getElementsByTagName("g")[0] || {}).focus;
                        c.focus && d && c.focus();
                        if (f && f.onmouseout) f.onmouseout();
                        if (c.onmouseover) c.onmouseover();
                        this.highlightedExportItemIx = a;
                        return !0
                    }
                };
            d.Chart.prototype.highlightLastExportItem = function () {
                var a;
                if (this.exportDivElements)for (a = this.exportDivElements.length; a--;)if (this.highlightExportItem(a))return !0;
                return !1
            };
            d = function () {
            };
            d.prototype = new k;
            e(d.prototype, {
                init: function () {
                    var a = this.chart, c = this;
                    this.addEvent(a, "exportMenuShown", function () {
                        c.onMenuShown()
                    });
                    this.addEvent(a, "exportMenuHidden", function () {
                        c.onMenuHidden()
                    })
                }, onMenuHidden: function () {
                    var a = this.chart.exportContextMenu;
                    a && a.setAttribute("aria-hidden", "true");
                    this.setExportButtonExpandedState("false")
                }, onMenuShown: function () {
                    var a = this.chart.exportContextMenu;
                    a && (this.addAccessibleContextMenuAttribs(), this.unhideElementFromScreenReaders(a),
                        this.chart.highlightExportItem(0));
                    this.setExportButtonExpandedState("true")
                }, setExportButtonExpandedState: function (a) {
                    var c = this.exportButtonProxy;
                    c && c.setAttribute("aria-expanded", a)
                }, onChartRender: function () {
                    var a = this.chart, c = a.options.accessibility;
                    this.removeElement(this.exportProxyGroup);
                    var f = a.options.exporting;
                    f && !1 !== f.enabled && f.accessibility && f.accessibility.enabled && a.exportSVGElements && a.exportSVGElements[0] && a.exportSVGElements[0].element && (this.exportProxyGroup = this.addProxyGroup("all" ===
                    c.landmarkVerbosity ? {
                        "aria-label": a.langFormat("accessibility.exporting.exportRegionLabel", {chart: a}),
                        role: "region"
                    } : null), this.exportButtonProxy = this.createProxyButton(this.chart.exportSVGElements[0], this.exportProxyGroup, {
                        "aria-label": a.langFormat("accessibility.exporting.menuButtonLabel", {chart: a}),
                        "aria-expanded": "false"
                    }))
                }, addAccessibleContextMenuAttribs: function () {
                    var a = this.chart, c = a.exportDivElements;
                    c && c.length && (c.forEach(function (a) {
                        "DIV" !== a.tagName || a.children && a.children.length ? a.setAttribute("aria-hidden",
                            "true") : (a.setAttribute("role", "listitem"), a.setAttribute("tabindex", 0))
                    }), c = c[0].parentNode, c.setAttribute("role", "list"), c.removeAttribute("aria-hidden"), c.setAttribute("aria-label", a.langFormat("accessibility.exporting.chartMenuLabel", {chart: a})))
                }, getKeyboardNavigation: function () {
                    var a = this.keyCodes, c = this.chart, f = this;
                    return new l(c, {
                        keyCodeMap: [[[a.left, a.up], function () {
                            f.onKbdPrevious(this)
                        }], [[a.right, a.down], function () {
                            f.onKbdNext(this)
                        }], [[a.enter, a.space], function () {
                            f.onKbdClick(this)
                        }],
                            [[a.esc], function () {
                                return this.response.prev
                            }]], validate: function () {
                            return c.exportChart && !1 !== c.options.exporting.enabled && !1 !== c.options.exporting.accessibility.enabled
                        }, init: function (a) {
                            c.showExportMenu();
                            0 > a && c.highlightLastExportItem()
                        }, terminate: function () {
                            c.hideExportMenu()
                        }
                    })
                }, onKbdPrevious: function (a) {
                    var c = this.chart, f = c.options.accessibility;
                    a = a.response;
                    for (var d = c.highlightedExportItemIx || 0; d--;)if (c.highlightExportItem(d))return a.success;
                    return f.keyboardNavigation.wrapAround ? (c.highlightLastExportItem(),
                        a.success) : a.prev
                }, onKbdNext: function (a) {
                    var c = this.chart, f = c.options.accessibility;
                    a = a.response;
                    for (var d = (c.highlightedExportItemIx || 0) + 1; d < c.exportDivElements.length; ++d)if (c.highlightExportItem(d))return a.success;
                    return f.keyboardNavigation.wrapAround ? (c.highlightExportItem(0), a.success) : a.next
                }, onKbdClick: function (a) {
                    var c = this.chart;
                    this.fakeClickEvent(c.exportDivElements[c.highlightedExportItemIx]);
                    return a.response.success
                }
            });
            return d
        });
    p(e, "modules/accessibility/components/SeriesComponent.js",
        [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigationHandler.js"], e["modules/accessibility/utilities.js"]], function (d, e, k, l, a) {
            function c(a) {
                var b = a.index, c = a.series.points, h = c.length;
                if (c[b] !== a)for (; h--;) {
                    if (c[h] === a)return h
                } else return b
            }

            function f(a) {
                var b = a.chart.options.accessibility, c = a.options.accessibility || {}, h = c.keyboardNavigation;
                return h && !1 === h.enabled || !1 === c.enabled || !1 === a.options.enableMouseTracking ||
                    !a.visible || b.pointNavigationThreshold && b.pointNavigationThreshold <= a.points.length
            }

            function g(a) {
                var b = a.series.chart.options.accessibility;
                return a.isNull && b.keyboardNavigation.skipNullPoints || !1 === a.visible || f(a.series)
            }

            var b = e.extend, n = e.isNumber, m = e.pick, q = d.merge, t = a.stripHTMLTagsFromString;
            d.Series.prototype.keyboardMoveVertical = !0;
            ["column", "pie"].forEach(function (a) {
                d.seriesTypes[a] && (d.seriesTypes[a].prototype.keyboardMoveVertical = !1)
            });
            d.addEvent(d.Series, "render", function () {
                var a = this.options,
                    b = this.chart.options.accessibility || {}, c = this.points || [], f = c.length,
                    d = this.resetA11yMarkerOptions;
                if (b.enabled && !1 !== (a.accessibility && a.accessibility.enabled) && (f < b.pointDescriptionThreshold || !1 === b.pointDescriptionThreshold || f < b.pointNavigationThreshold || !1 === b.pointNavigationThreshold)) {
                    if (a.marker && !1 === a.marker.enabled && (this.a11yMarkersForced = !0, q(!0, this.options, {
                            marker: {
                                enabled: !0,
                                states: {normal: {opacity: 0}}
                            }
                        })), this._hasPointMarkers && this.points && this.points.length)for (a = f; a--;)b = c[a].options,
                    b.marker && (b.marker.enabled ? q(!0, b.marker, {states: {normal: {opacity: b.marker.states && b.marker.states.normal && b.marker.states.normal.opacity || 1}}}) : q(!0, b.marker, {
                        enabled: !0,
                        states: {normal: {opacity: 0}}
                    }))
                } else this.a11yMarkersForced && d && (delete this.a11yMarkersForced, q(!0, this.options, {
                    marker: {
                        enabled: d.enabled,
                        states: {normal: {opacity: d.states && d.states.normal && d.states.normal.opacity}}
                    }
                }))
            });
            d.addEvent(d.Series, "afterSetOptions", function (a) {
                this.resetA11yMarkerOptions = q(a.options.marker || {}, this.userOptions.marker ||
                    {})
            });
            d.Point.prototype.highlight = function () {
                var a = this.series.chart;
                if (this.isNull) a.tooltip && a.tooltip.hide(0); else this.onMouseOver();
                this.graphic && a.setFocusToElement(this.graphic);
                a.highlightedPoint = this;
                return this
            };
            d.Chart.prototype.highlightAdjacentPoint = function (a) {
                var b = this.series, h = this.highlightedPoint, d = h && c(h) || 0, e = h && h.series.points,
                    n = this.series && this.series[this.series.length - 1];
                n = n && n.points && n.points[n.points.length - 1];
                if (!b[0] || !b[0].points)return !1;
                if (h) {
                    if (b = b[h.series.index +
                        (a ? 1 : -1)], d = e[d + (a ? 1 : -1)], !d && b && (d = b.points[a ? 0 : b.points.length - 1]), !d)return !1
                } else d = a ? b[0].points[0] : n;
                return g(d) ? (b = d.series, f(b) ? this.highlightedPoint = a ? b.points[b.points.length - 1] : b.points[0] : this.highlightedPoint = d, this.highlightAdjacentPoint(a)) : d.highlight()
            };
            d.Series.prototype.highlightFirstValidPoint = function () {
                var a = this.chart.highlightedPoint, b = (a && a.series) === this ? c(a) : 0;
                a = this.points;
                var d = a.length;
                if (a && d) {
                    for (var f = b; f < d; ++f)if (!g(a[f]))return a[f].highlight();
                    for (; 0 <= b; --b)if (!g(a[b]))return a[b].highlight()
                }
                return !1
            };
            d.Chart.prototype.highlightAdjacentSeries = function (a) {
                var b, c, h = this.highlightedPoint,
                    d = (b = this.series && this.series[this.series.length - 1]) && b.points && b.points[b.points.length - 1];
                if (!this.highlightedPoint)return b = a ? this.series && this.series[0] : b, (c = a ? b && b.points && b.points[0] : d) ? c.highlight() : !1;
                b = this.series[h.series.index + (a ? -1 : 1)];
                if (!b)return !1;
                d = Infinity;
                var e = b.points.length;
                if (void 0 === h.plotX || void 0 === h.plotY) c = void 0; else {
                    for (; e--;) {
                        var g = b.points[e];
                        void 0 !== g.plotX && void 0 !== g.plotY && (g =
                            (h.plotX - g.plotX) * (h.plotX - g.plotX) * 4 + (h.plotY - g.plotY) * (h.plotY - g.plotY), g < d && (d = g, c = e))
                    }
                    c = void 0 !== c && b.points[c]
                }
                if (!c)return !1;
                if (f(b))return c.highlight(), a = this.highlightAdjacentSeries(a), a ? a : (h.highlight(), !1);
                c.highlight();
                return c.series.highlightFirstValidPoint()
            };
            d.Chart.prototype.highlightAdjacentPointVertical = function (a) {
                var b = this.highlightedPoint, c = Infinity, h;
                if (void 0 === b.plotX || void 0 === b.plotY)return !1;
                this.series.forEach(function (d) {
                    f(d) || d.points.forEach(function (f) {
                        if (void 0 !==
                            f.plotY && void 0 !== f.plotX && f !== b) {
                            var e = f.plotY - b.plotY, r = Math.abs(f.plotX - b.plotX);
                            r = Math.abs(e) * Math.abs(e) + r * r * 4;
                            d.yAxis.reversed && (e *= -1);
                            !(0 >= e && a || 0 <= e && !a || 5 > r || g(f)) && r < c && (c = r, h = f)
                        }
                    })
                });
                return h ? h.highlight() : !1
            };
            d.Point.prototype.getA11yTimeDescription = function () {
                var a = this.series, b = a.chart, c = b.options.accessibility;
                if (a.xAxis && a.xAxis.isDatetimeAxis)return b.time.dateFormat(c.pointDateFormatter && c.pointDateFormatter(this) || c.pointDateFormat || d.Tooltip.prototype.getXDateFormat.call({
                        getDateFormat: d.Tooltip.prototype.getDateFormat,
                        chart: b
                    }, this, b.options.tooltip, a.xAxis), this.x)
            };
            e = function () {
            };
            e.prototype = new k;
            b(e.prototype, {
                init: function () {
                    var a = this;
                    this.addEvent(d.Series, "destroy", function () {
                        var b = this.chart;
                        b === a.chart && b.highlightedPoint && b.highlightedPoint.series === this && (delete b.highlightedPoint, b.focusElement && b.focusElement.removeFocusBorder())
                    });
                    this.addEvent(d.Tooltip, "refresh", function () {
                        this.chart === a.chart && this.label && this.label.element && this.label.element.setAttribute("aria-hidden", !0)
                    });
                    this.addEvent(this.chart,
                        "afterDrawSeriesLabels", function () {
                            this.series.forEach(function (a) {
                                a.labelBySeries && a.labelBySeries.attr("aria-hidden", !0)
                            })
                        });
                    this.initAnnouncer()
                }, onChartRender: function () {
                    var a = this;
                    this.chart.series.forEach(function (b) {
                        a[!1 !== (b.options.accessibility && b.options.accessibility.enabled) && b.visible ? "addSeriesDescription" : "hideSeriesFromScreenReader"](b)
                    })
                }, getKeyboardNavigation: function () {
                    var a = this.keyCodes, b = this.chart, c = b.inverted, f = b.options.accessibility,
                        d = function (a) {
                            return b.highlightAdjacentPoint(a) ?
                                this.response.success : f.keyboardNavigation.wrapAround ? this.init(a ? 1 : -1) : this.response[a ? "next" : "prev"]
                        };
                    return new l(b, {
                        keyCodeMap: [[[c ? a.up : a.left, c ? a.down : a.right], function (b) {
                            return d.call(this, b === a.right || b === a.down)
                        }], [[c ? a.left : a.up, c ? a.right : a.down], function (c) {
                            c = c === a.down || c === a.right;
                            var h = f.keyboardNavigation;
                            if (h.mode && "serialize" === h.mode)return d.call(this, c);
                            b[b.highlightedPoint && b.highlightedPoint.series.keyboardMoveVertical ? "highlightAdjacentPointVertical" : "highlightAdjacentSeries"](c);
                            return this.response.success
                        }], [[a.enter, a.space], function () {
                            b.highlightedPoint && b.highlightedPoint.firePointEvent("click")
                        }]], init: function (a) {
                            var c = b.series.length, f = 0 < a ? 0 : c;
                            if (0 < a)for (delete b.highlightedPoint; f < c && !(a = b.series[f].highlightFirstValidPoint());)++f; else for (; f-- && !(b.highlightedPoint = b.series[f].points[b.series[f].points.length - 1], a = b.series[f].highlightFirstValidPoint()););
                            return this.response.success
                        }, terminate: function () {
                            b.tooltip && b.tooltip.hide(0);
                            delete b.highlightedPoint
                        }
                    })
                },
                isPointClickable: function (a) {
                    var b = a.series.options || {};
                    b = b.point && b.point.events;
                    return a && a.graphic && a.graphic.element && (a.hcEvents && a.hcEvents.click || b && b.click || a.options && a.options.events && a.options.events.click)
                }, initAnnouncer: function () {
                    var a = this.chart, b = a.options.accessibility, c = this;
                    this.lastAnnouncementTime = 0;
                    this.dirty = {allSeries: {}};
                    this.announceRegion = this.createElement("div");
                    this.announceRegion.setAttribute("aria-hidden", !1);
                    this.announceRegion.setAttribute("aria-live", b.announceNewData.interruptUser ?
                        "assertive" : "polite");
                    q(!0, this.announceRegion.style, this.hiddenStyle);
                    a.renderTo.insertBefore(this.announceRegion, a.renderTo.firstChild);
                    this.addEvent(this.chart, "afterDrilldown", function () {
                        a.highlightedPoint = null;
                        if (a.options.accessibility.announceNewData.enabled) {
                            if (this.series && this.series.length) {
                                var b = c.getSeriesElement(this.series[0]);
                                b.focus && b.getAttribute("aria-label") ? b.focus() : this.series[0].highlightFirstValidPoint()
                            }
                            c.lastAnnouncementTime = 0;
                            a.focusElement && a.focusElement.removeFocusBorder()
                        }
                    });
                    this.addEvent(d.Series, "updatedData", function () {
                        this.chart === a && this.chart.options.accessibility.announceNewData.enabled && (c.dirty.hasDirty = !0, c.dirty.allSeries[this.name + this.index] = this)
                    });
                    this.addEvent(a, "afterAddSeries", function (a) {
                        this.options.accessibility.announceNewData.enabled && (a = a.series, c.dirty.hasDirty = !0, c.dirty.allSeries[a.name + a.index] = a, c.dirty.newSeries = void 0 === c.dirty.newSeries ? a : null)
                    });
                    this.addEvent(d.Series, "addPoint", function (b) {
                        this.chart === a && this.chart.options.accessibility.announceNewData.enabled &&
                        (c.dirty.newPoint = void 0 === c.dirty.newPoint ? b.point : null)
                    });
                    this.addEvent(a, "redraw", function () {
                        if (this.options.accessibility.announceNewData && c.dirty.hasDirty) {
                            var a = c.dirty.newPoint;
                            if (a) {
                                var b = a.series.data.filter(function (b) {
                                    return b.x === a.x && b.y === a.y
                                });
                                a = 1 === b.length ? b[0] : a
                            }
                            c.announceNewData(Object.keys(c.dirty.allSeries).map(function (a) {
                                return c.dirty.allSeries[a]
                            }), c.dirty.newSeries, a);
                            c.dirty = {allSeries: {}}
                        }
                    })
                }, announceNewData: function (a, b, c) {
                    var f = this.chart.options.accessibility.announceNewData;
                    if (f.enabled) {
                        var d = this, h = +new Date;
                        f = Math.max(0, f.minAnnounceInterval - (h - this.lastAnnouncementTime));
                        if (this.queuedAnnouncement) {
                            var e = (this.queuedAnnouncement.series || []).concat(a).reduce(function (a, b) {
                                a[b.name + b.index] = b;
                                return a
                            }, {});
                            a = Object.keys(e).map(function (a) {
                                return e[a]
                            })
                        } else a = [].concat(a);
                        if (b = this.buildAnnouncementMessage(a, b, c)) this.queuedAnnouncement && clearTimeout(this.queuedAnnouncementTimer), this.queuedAnnouncement = {
                            time: h,
                            message: b,
                            series: a
                        }, d.queuedAnnouncementTimer = setTimeout(function () {
                            d &&
                            d.announceRegion && (d.lastAnnouncementTime = +new Date, d.announceRegion.innerHTML = d.queuedAnnouncement.message, d.clearAnnouncementContainerTimer && clearTimeout(d.clearAnnouncementContainerTimer), d.clearAnnouncementContainerTimer = setTimeout(function () {
                                d.announceRegion.innerHTML = "";
                                delete d.clearAnnouncementContainerTimer
                            }, 1E3), delete d.queuedAnnouncement, delete d.queuedAnnouncementTimer)
                        }, f)
                    }
                }, buildAnnouncementMessage: function (a, b, c) {
                    var f = this.chart, e = f.options.accessibility.announceNewData;
                    if (e.announcementFormatter &&
                        (a = e.announcementFormatter(a, b, c), !1 !== a))return a.length ? a : null;
                    a = d.charts && 1 < d.charts.length ? "Multiple" : "Single";
                    return f.langFormat("accessibility.announceNewData." + (b ? "newSeriesAnnounce" + a : c ? "newPointAnnounce" + a : "newDataAnnounce"), {
                        chartTitle: t(f.options.title.text || f.langFormat("accessibility.defaultChartTitle", {chart: f})),
                        seriesDesc: b ? this.defaultSeriesDescriptionFormatter(b) : null,
                        pointDesc: c ? this.defaultPointDescriptionFormatter(c) : null,
                        point: c,
                        series: b
                    })
                }, reverseChildNodes: function (a) {
                    for (var b =
                        a.childNodes.length; b--;)a.appendChild(a.childNodes[b])
                }, getSeriesFirstPointElement: function (a) {
                    return a.points && a.points.length && a.points[0].graphic && a.points[0].graphic.element
                }, getSeriesElement: function (a) {
                    var b = this.getSeriesFirstPointElement(a);
                    return b && b.parentNode || a.graph && a.graph.element || a.group && a.group.element
                }, hideSeriesFromScreenReader: function (a) {
                    (a = this.getSeriesElement(a)) && a.setAttribute("aria-hidden", !0)
                }, addSeriesDescription: function (a) {
                    var b = this, c = a.chart, f = c.options.accessibility,
                        d = a.options.accessibility || {}, e = b.getSeriesFirstPointElement(a),
                        g = b.getSeriesElement(a),
                        h = a.points && (a.points.length < f.pointDescriptionThreshold || !1 === f.pointDescriptionThreshold) && !d.exposeAsGroupOnly,
                        n = a.points && (a.points.length < f.pointNavigationThreshold || !1 === f.pointNavigationThreshold);
                    g && (g.lastChild === e && b.reverseChildNodes(g), b.unhideElementFromScreenReaders(g), (h || n) && a.points.forEach(function (a) {
                        var c = a.graphic && a.graphic.element;
                        c && (c.setAttribute("tabindex", "-1"), h ? (c.setAttribute("role",
                            "img"), c.setAttribute("aria-label", t(d.pointDescriptionFormatter && d.pointDescriptionFormatter(a) || f.pointDescriptionFormatter && f.pointDescriptionFormatter(a) || b.defaultPointDescriptionFormatter(a)))) : c.setAttribute("aria-hidden", !0))
                    }), 1 < c.series.length || f.describeSingleSeries ? (d.exposeAsGroupOnly ? g.setAttribute("role", "img") : "all" === f.landmarkVerbosity && g.setAttribute("role", "region"), g.setAttribute("tabindex", "-1"), g.setAttribute("aria-label", t(f.seriesDescriptionFormatter && f.seriesDescriptionFormatter(a) ||
                        b.defaultSeriesDescriptionFormatter(a)))) : g.setAttribute("aria-label", ""))
                }, defaultSeriesDescriptionFormatter: function (a) {
                    var b = a.chart, c = (a.options.accessibility || {}).description;
                    c = c && b.langFormat("accessibility.series.description", {description: c, series: a});
                    var f = b.langFormat("accessibility.series.xAxisDescription", {
                        name: a.xAxis && a.xAxis.getDescription(),
                        series: a
                    }), d = b.langFormat("accessibility.series.yAxisDescription", {
                        name: a.yAxis && a.yAxis.getDescription(),
                        series: a
                    }), g = {
                        name: a.name || "", ix: a.index +
                        1, numSeries: b.series && b.series.length, numPoints: a.points && a.points.length, series: a
                    }, e = b.types && 1 < b.types.length ? "Combination" : "";
                    return (b.langFormat("accessibility.series.summary." + a.type + e, g) || b.langFormat("accessibility.series.summary.default" + e, g)) + (c ? " " + c : "") + (b.yAxis && 1 < b.yAxis.length && this.yAxis ? " " + d : "") + (b.xAxis && 1 < b.xAxis.length && this.xAxis ? " " + f : "")
                }, defaultPointDescriptionFormatter: function (a) {
                    var b = a.series, c = b.chart, f = c.options.accessibility, g = a.series.tooltipOptions || {},
                        e = f.pointValuePrefix ||
                            g.valuePrefix || "", q = f.pointValueSuffix || g.valueSuffix || "",
                        h = a.options && a.options.accessibility && a.options.accessibility.description,
                        t = a.getA11yTimeDescription(), w = function (a) {
                            if (n(a)) {
                                var b = d.defaultOptions.lang;
                                return d.numberFormat(a, f.pointValueDecimals || g.valueDecimals || -1, b.decimalPoint, b.accessibility.thousandsSep || b.thousandsSep)
                            }
                            return a
                        },
                        B = m(b.xAxis && b.xAxis.options.accessibility && b.xAxis.options.accessibility.enabled, !c.angular),
                        k = b.xAxis && b.xAxis.categories && void 0 !== a.category && "" + a.category;
                    t = a.name || t || k && k.replace("<br/>", " ") || (a.id && 0 > a.id.indexOf("highcharts-") ? a.id : "x, " + a.x);
                    k = a.series.pointArrayMap ? a.series.pointArrayMap.reduce(function (b, c) {
                        return b + (b.length ? ", " : "") + c + ": " + e + w(m(a[c], a.options[c])) + q
                    }, "") : void 0 !== a.value ? e + w(a.value) + q : e + w(a.y) + q;
                    return (void 0 !== a.index ? a.index + 1 + ". " : "") + (B ? t + ", " : "") + k + "." + (h ? " " + h : "") + (1 < c.series.length && b.name ? " " + b.name : "")
                }
            });
            return e
        });
    p(e, "modules/accessibility/components/ZoomComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"],
        e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigationHandler.js"]], function (d, e, k, l) {
        e = e.extend;
        d.Axis.prototype.panStep = function (a, c) {
            var f = c || 3;
            c = this.getExtremes();
            var d = (c.max - c.min) / f * a;
            f = c.max + d;
            d = c.min + d;
            var b = f - d;
            0 > a && d < c.dataMin ? (d = c.dataMin, f = d + b) : 0 < a && f > c.dataMax && (f = c.dataMax, d = f - b);
            this.setExtremes(d, f)
        };
        d = function () {
        };
        d.prototype = new k;
        e(d.prototype, {
            init: function () {
                var a = this, c = this.chart;
                ["afterShowResetZoom", "afterDrilldown", "drillupall"].forEach(function (f) {
                    a.addEvent(c,
                        f, function () {
                            a.updateProxyOverlays()
                        })
                })
            }, onChartUpdate: function () {
                var a = this.chart, c = this;
                a.mapNavButtons && a.mapNavButtons.forEach(function (f, d) {
                    c.unhideElementFromScreenReaders(f.element);
                    f.element.setAttribute("tabindex", -1);
                    f.element.setAttribute("role", "button");
                    f.element.setAttribute("aria-label", a.langFormat("accessibility.mapZoom" + (d ? "Out" : "In"), {chart: a}))
                })
            }, onChartRender: function () {
                this.updateProxyOverlays()
            }, updateProxyOverlays: function () {
                var a = this, c = this.chart, f = function (c, b, f, d) {
                    a.removeElement(a[f]);
                    a[f] = a.addProxyGroup();
                    a[b] = a.createProxyButton(c, a[f], {"aria-label": d, tabindex: -1})
                };
                a.removeElement(a.drillUpProxyGroup);
                a.removeElement(a.resetZoomProxyGroup);
                c.resetZoomButton && f(c.resetZoomButton, "resetZoomProxyButton", "resetZoomProxyGroup", c.langFormat("accessibility.resetZoomButton", {chart: c}));
                c.drillUpButton && f(c.drillUpButton, "drillUpProxyButton", "drillUpProxyGroup", c.langFormat("accessibility.drillUpButton", {
                    chart: c,
                    buttonText: c.getDrilldownBackText()
                }))
            }, getMapZoomNavigation: function () {
                var a =
                    this.keyCodes, c = this.chart, f = this;
                return new l(c, {
                    keyCodeMap: [[[a.up, a.down, a.left, a.right], function (f) {
                        c[f === a.up || f === a.down ? "yAxis" : "xAxis"][0].panStep(f === a.left || f === a.up ? -1 : 1);
                        return this.response.success
                    }], [[a.tab], function (a, b) {
                        c.mapNavButtons[f.focusedMapNavButtonIx].setState(0);
                        if (b.shiftKey && !f.focusedMapNavButtonIx || !b.shiftKey && f.focusedMapNavButtonIx)return c.mapZoom(), this.response[b.shiftKey ? "prev" : "next"];
                        f.focusedMapNavButtonIx += b.shiftKey ? -1 : 1;
                        a = c.mapNavButtons[f.focusedMapNavButtonIx];
                        c.setFocusToElement(a.box, a.element);
                        a.setState(2);
                        return this.response.success
                    }], [[a.space, a.enter], function () {
                        f.fakeClickEvent(c.mapNavButtons[f.focusedMapNavButtonIx].element);
                        return this.response.success
                    }]], validate: function () {
                        return c.mapZoom && c.mapNavButtons && 2 === c.mapNavButtons.length
                    }, init: function (a) {
                        var b = c.mapNavButtons[0], d = c.mapNavButtons[1];
                        b = 0 < a ? b : d;
                        c.setFocusToElement(b.box, b.element);
                        b.setState(2);
                        f.focusedMapNavButtonIx = 0 < a ? 0 : 1
                    }
                })
            }, simpleButtonNavigation: function (a, c, f) {
                var d = this.keyCodes,
                    b = this, e = this.chart;
                return new l(e, {
                    keyCodeMap: [[[d.tab, d.up, d.down, d.left, d.right], function (a, b) {
                        return this.response[a === this.tab && b.shiftKey || a === d.left || a === d.up ? "prev" : "next"]
                    }], [[d.space, d.enter], function () {
                        f(e);
                        return this.response.success
                    }]], validate: function () {
                        return e[a] && e[a].box && b[c]
                    }, init: function () {
                        e.setFocusToElement(e[a].box, b[c])
                    }
                })
            }, getKeyboardNavigation: function () {
                return [this.simpleButtonNavigation("resetZoomButton", "resetZoomProxyButton", function (a) {
                    a.zoomOut()
                }), this.simpleButtonNavigation("drillUpButton",
                    "drillUpProxyButton", function (a) {
                        a.drillUp()
                    }), this.getMapZoomNavigation()]
            }
        });
        return d
    });
    p(e, "modules/accessibility/components/RangeSelectorComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigationHandler.js"]], function (d, e, k, l) {
        e = e.extend;
        d.Chart.prototype.highlightRangeSelectorButton = function (a) {
            var c = this.rangeSelector.buttons;
            c[this.highlightedRangeSelectorItemIx] && c[this.highlightedRangeSelectorItemIx].setState(this.oldRangeSelectorItemState ||
                0);
            this.highlightedRangeSelectorItemIx = a;
            return c[a] ? (this.setFocusToElement(c[a].box, c[a].element), this.oldRangeSelectorItemState = c[a].state, c[a].setState(2), !0) : !1
        };
        d = function () {
        };
        d.prototype = new k;
        e(d.prototype, {
            onChartUpdate: function () {
                var a = this.chart, c = this, d = a.rangeSelector;
                d && (d.buttons && d.buttons.length && d.buttons.forEach(function (d) {
                    c.unhideElementFromScreenReaders(d.element);
                    d.element.setAttribute("tabindex", "-1");
                    d.element.setAttribute("role", "button");
                    d.element.setAttribute("aria-label",
                        a.langFormat("accessibility.rangeSelectorButton", {
                            chart: a,
                            buttonText: d.text && d.text.textStr
                        }))
                }), d.maxInput && d.minInput && ["minInput", "maxInput"].forEach(function (f, b) {
                    d[f] && (c.unhideElementFromScreenReaders(d[f]), d[f].setAttribute("tabindex", "-1"), d[f].setAttribute("role", "textbox"), d[f].setAttribute("aria-label", a.langFormat("accessibility.rangeSelector" + (b ? "MaxInput" : "MinInput"), {chart: a})))
                }))
            }, getRangeSelectorButtonNavigation: function () {
                var a = this.chart, c = this.keyCodes, d = a.options.accessibility,
                    e = this;
                return new l(a, {
                    keyCodeMap: [[[c.left, c.right, c.up, c.down], function (b) {
                        b = b === c.left || b === c.up ? -1 : 1;
                        if (!a.highlightRangeSelectorButton(a.highlightedRangeSelectorItemIx + b))return d.keyboardNavigation.wrapAround ? (this.init(b), this.response.success) : this.response[0 < b ? "next" : "prev"]
                    }], [[c.enter, c.space], function () {
                        3 !== a.oldRangeSelectorItemState && e.fakeClickEvent(a.rangeSelector.buttons[a.highlightedRangeSelectorItemIx].element)
                    }]], validate: function () {
                        return a.rangeSelector && a.rangeSelector.buttons &&
                            a.rangeSelector.buttons.length
                    }, init: function (b) {
                        a.highlightRangeSelectorButton(0 < b ? 0 : a.rangeSelector.buttons.length - 1)
                    }
                })
            }, getRangeSelectorInputNavigation: function () {
                var a = this.chart, c = this.keyCodes;
                return new l(a, {
                    keyCodeMap: [[[c.tab, c.up, c.down], function (d, e) {
                        d = d === c.tab && e.shiftKey || d === c.up ? -1 : 1;
                        e = a.highlightedInputRangeIx += d;
                        if (1 < e || 0 > e)return this.response[0 < d ? "next" : "prev"];
                        a.rangeSelector[e ? "maxInput" : "minInput"].focus();
                        return this.response.success
                    }]], validate: function () {
                        return a.rangeSelector &&
                            a.rangeSelector.inputGroup && "hidden" !== a.rangeSelector.inputGroup.element.getAttribute("visibility") && !1 !== a.options.rangeSelector.inputEnabled && a.rangeSelector.minInput && a.rangeSelector.maxInput
                    }, init: function (c) {
                        a.highlightedInputRangeIx = 0 < c ? 0 : 1;
                        a.rangeSelector[a.highlightedInputRangeIx ? "maxInput" : "minInput"].focus()
                    }, terminate: function () {
                        var c = a.rangeSelector;
                        c && c.maxInput && c.minInput && (c.hideInput("max"), c.hideInput("min"))
                    }
                })
            }, getKeyboardNavigation: function () {
                return [this.getRangeSelectorButtonNavigation(),
                    this.getRangeSelectorInputNavigation()]
            }
        });
        return d
    });
    p(e, "modules/accessibility/components/InfoRegionComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/utilities.js"]], function (d, e, k, l) {
        var a = e.extend, c = e.pick, f = d.merge, g = l.makeHTMLTagFromText;
        d.Chart.prototype.getTypeDescription = function (a) {
            a = a[0];
            var b = this.series && this.series[0] || {}, c = b.mapTitle;
            b = {
                numSeries: this.series.length, numPoints: b.points && b.points.length,
                chart: this, mapTitle: c
            };
            if (!a)return this.langFormat("accessibility.chartTypes.emptyChart", b);
            if ("map" === a)return c ? this.langFormat("accessibility.chartTypes.mapTypeDescription", b) : this.langFormat("accessibility.chartTypes.unknownMap", b);
            if (1 < this.types.length)return this.langFormat("accessibility.chartTypes.combinationChart", b);
            c = this.langFormat("accessibility.seriesTypeDescriptions." + a, {chart: this});
            var d = this.series && 1 === this.series.length ? "Single" : "Multiple";
            return (this.langFormat("accessibility.chartTypes." +
                    a + d, b) || this.langFormat("accessibility.chartTypes.default" + d, b)) + (c ? " " + c : "")
        };
        d = function () {
        };
        d.prototype = new k;
        a(d.prototype, {
            init: function () {
                var a = this.chart, c = this;
                this.addEvent(a, "afterGetTable", function (b) {
                    a.options.accessibility.enabled && (c.tableAnchor.setAttribute("aria-expanded", !0), b.html = b.html.replace("<table ", '<table tabindex="0" summary="' + a.langFormat("accessibility.tableSummary", {chart: a}) + '"'))
                });
                this.addEvent(a, "afterViewData", function (a) {
                    setTimeout(function () {
                        var b = a && a.getElementsByTagName("table")[0];
                        b && b.focus && b.focus()
                    }, 300)
                })
            }, onChartUpdate: function () {
                var a = this.chart, c = a.options.accessibility, d = "highcharts-information-region-" + a.index,
                    e = this.screenReaderRegion = this.screenReaderRegion || this.createElement("div"),
                    g = this.tableHeading = this.tableHeading || this.createElement("h6"),
                    h = this.tableAnchor = this.tableAnchor || this.createElement("a"),
                    k = this.chartHeading = this.chartHeading || this.createElement("h6");
                e.setAttribute("id", d);
                "all" === c.landmarkVerbosity && e.setAttribute("role", "region");
                e.setAttribute("aria-label",
                    a.langFormat("accessibility.screenReaderRegionLabel", {chart: a}));
                e.innerHTML = c.screenReaderSectionFormatter ? c.screenReaderSectionFormatter(a) : this.defaultScreenReaderSectionFormatter(a);
                a.getCSV && a.options.accessibility.addTableShortcut && (c = "highcharts-data-table-" + a.index, h.innerHTML = a.langFormat("accessibility.viewAsDataTable", {chart: a}), h.href = "#" + c, h.setAttribute("tabindex", "-1"), h.setAttribute("role", "button"), h.setAttribute("aria-expanded", !1), h.onclick = a.options.accessibility.onTableAnchorClick ||
                    function () {
                        a.viewData()
                    }, g.appendChild(h), e.appendChild(g));
                k.innerHTML = a.langFormat("accessibility.chartHeading", {chart: a});
                k.setAttribute("aria-hidden", !1);
                a.renderTo.insertBefore(k, a.renderTo.firstChild);
                a.renderTo.insertBefore(e, a.renderTo.firstChild);
                this.unhideElementFromScreenReaders(e);
                f(!0, k.style, this.hiddenStyle);
                f(!0, e.style, this.hiddenStyle)
            }, defaultScreenReaderSectionFormatter: function () {
                var a = this.chart.options;
                return this.defaultTypeDescriptionHTML(this.chart) + this.defaultSubtitleHTML(a) +
                    this.defaultCaptionHTML(a) + this.defaultAxisDescriptionHTML("xAxis") + this.defaultAxisDescriptionHTML("yAxis")
            }, defaultCaptionHTML: function (a) {
                var b = a.caption;
                b = b && b.text;
                return (a = a.accessibility.description || b) ? g("div", a) : ""
            }, defaultAxisDescriptionHTML: function (a) {
                return (a = this.getAxesDescription()[a]) ? g("div", a) : ""
            }, defaultTypeDescriptionHTML: function (a) {
                return a.types ? g("h5", a.options.accessibility.typeDescription || a.getTypeDescription(a.types)) : ""
            }, defaultSubtitleHTML: function (a) {
                return (a = (a = a.subtitle) &&
                    a.text) ? g("div", a) : ""
            }, getAxesDescription: function () {
                var a = this.chart, d = this, f = a.xAxis,
                    e = 1 < f.length || f[0] && c(f[0].options.accessibility && f[0].options.accessibility.enabled, !a.angular && a.hasCartesianSeries && 0 > a.types.indexOf("map")),
                    g = a.yAxis,
                    h = 1 < g.length || g[0] && c(g[0].options.accessibility && g[0].options.accessibility.enabled, a.hasCartesianSeries && 0 > a.types.indexOf("map")),
                    k = {};
                e && (k.xAxis = a.langFormat("accessibility.axis.xAxisDescription" + (1 < f.length ? "Plural" : "Singular"), {
                    chart: a, names: a.xAxis.map(function (a) {
                        return a.getDescription()
                    }),
                    ranges: a.xAxis.map(function (a) {
                        return d.getAxisRangeDescription(a)
                    }), numAxes: f.length
                }));
                h && (k.yAxis = a.langFormat("accessibility.axis.yAxisDescription" + (1 < g.length ? "Plural" : "Singular"), {
                    chart: a,
                    names: a.yAxis.map(function (a) {
                        return a.getDescription()
                    }),
                    ranges: a.yAxis.map(function (a) {
                        return d.getAxisRangeDescription(a)
                    }),
                    numAxes: g.length
                }));
                return k
            }, getAxisRangeDescription: function (a) {
                var b = this.chart, c = a.options || {};
                if (c.accessibility && void 0 !== c.accessibility.rangeDescription)return c.accessibility.rangeDescription;
                if (a.categories)return b.langFormat("accessibility.axis.rangeCategories", {
                    chart: b,
                    axis: a,
                    numCategories: a.dataMax - a.dataMin + 1
                });
                if (a.isDatetimeAxis && (0 === a.min || 0 === a.dataMin)) {
                    var d = {}, f = "Seconds";
                    d.Seconds = (a.max - a.min) / 1E3;
                    d.Minutes = d.Seconds / 60;
                    d.Hours = d.Minutes / 60;
                    d.Days = d.Hours / 24;
                    ["Minutes", "Hours", "Days"].forEach(function (a) {
                        2 < d[a] && (f = a)
                    });
                    d.value = d[f].toFixed("Seconds" !== f && "Minutes" !== f ? 1 : 0);
                    return b.langFormat("accessibility.axis.timeRange" + f, {
                        chart: b, axis: a, range: d.value.replace(".0",
                            "")
                    })
                }
                c = b.options.accessibility;
                return b.langFormat("accessibility.axis.rangeFromTo", {
                    chart: b,
                    axis: a,
                    rangeFrom: a.isDatetimeAxis ? b.time.dateFormat(c.axisRangeDateFormat, a.min) : a.min,
                    rangeTo: a.isDatetimeAxis ? b.time.dateFormat(c.axisRangeDateFormat, a.max) : a.max
                })
            }
        });
        return d
    });
    p(e, "modules/accessibility/components/ContainerComponent.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/utilities.js"]], function (d, e, k, l) {
        e = e.extend;
        var a = d.win.document, c = l.stripHTMLTagsFromString;
        d = function () {
        };
        d.prototype = new k;
        e(d.prototype, {
            onChartUpdate: function () {
                var d = this.chart, e = d.options.accessibility, b = "highcharts-title-" + d.index,
                    n = d.options.title.text || d.langFormat("accessibility.defaultChartTitle", {chart: d}),
                    m = c(d.langFormat("accessibility.svgContainerTitle", {chartTitle: n})),
                    k = c(d.langFormat("accessibility.svgContainerLabel", {chartTitle: n}));
                if (m.length) {
                    var l = this.svgTitleElement = this.svgTitleElement || a.createElementNS("http://www.w3.org/2000/svg",
                            "title");
                    l.textContent = m;
                    l.id = b;
                    d.renderTo.insertBefore(l, d.renderTo.firstChild)
                }
                d.renderer.box && k.length && d.renderer.box.setAttribute("aria-label", k);
                "disabled" !== e.landmarkVerbosity ? d.renderTo.setAttribute("role", "region") : d.renderTo.removeAttribute("role");
                d.renderTo.setAttribute("aria-label", d.langFormat("accessibility.chartContainerLabel", {
                    title: c(n),
                    chart: d
                }));
                if (e = d.credits && d.credits.element) d.credits.textStr && e.setAttribute("aria-label", c(d.langFormat("accessibility.credits", {creditsStr: d.credits.textStr}))),
                    this.unhideElementFromScreenReaders(e)
            }, destroy: function () {
                this.chart.renderTo.setAttribute("aria-hidden", !0)
            }
        });
        return d
    });
    p(e, "modules/accessibility/high-contrast-mode.js", [e["parts/Globals.js"]], function (d) {
        var e = d.isMS, k = d.win, l = k.document;
        return {
            isHighContrastModeActive: function () {
                if (k.matchMedia && e && /Edge\/\d./i.test(k.navigator.userAgent))return k.matchMedia("(-ms-high-contrast: active)").matches;
                if (e && k.getComputedStyle) {
                    var a = l.createElement("div");
                    a.style.backgroundImage = "url(#)";
                    l.body.appendChild(a);
                    var c = (a.currentStyle || k.getComputedStyle(a)).backgroundImage;
                    l.body.removeChild(a);
                    return "none" === c
                }
                return !1
            }, setHighContrastTheme: function (a) {
                a.highContrastModeActive = !0;
                var c = a.options.accessibility.highContrastTheme;
                a.update(c, !1);
                a.series.forEach(function (a) {
                    var d = c.plotOptions[a.type] || {};
                    a.update({
                        color: d.color || "windowText",
                        colors: [d.color || "windowText"],
                        borderColor: d.borderColor || "window"
                    });
                    a.points.forEach(function (a) {
                        a.options && a.options.color && a.update({
                            color: d.color || "windowText", borderColor: d.borderColor ||
                            "window"
                        }, !1)
                    })
                });
                a.redraw()
            }
        }
    });
    p(e, "modules/accessibility/high-contrast-theme.js", [], function () {
        return {
            chart: {backgroundColor: "window"},
            title: {style: {color: "windowText"}},
            subtitle: {style: {color: "windowText"}},
            colorAxis: {minColor: "windowText", maxColor: "windowText", stops: null},
            colors: ["windowText"],
            xAxis: {
                gridLineColor: "windowText",
                labels: {style: {color: "windowText"}},
                lineColor: "windowText",
                minorGridLineColor: "windowText",
                tickColor: "windowText",
                title: {style: {color: "windowText"}}
            },
            yAxis: {
                gridLineColor: "windowText",
                labels: {style: {color: "windowText"}},
                lineColor: "windowText",
                minorGridLineColor: "windowText",
                tickColor: "windowText",
                title: {style: {color: "windowText"}}
            },
            tooltip: {backgroundColor: "window", borderColor: "windowText", style: {color: "windowText"}},
            plotOptions: {
                series: {
                    lineColor: "windowText",
                    fillColor: "window",
                    borderColor: "windowText",
                    edgeColor: "windowText",
                    borderWidth: 1,
                    dataLabels: {
                        connectorColor: "windowText",
                        color: "windowText",
                        style: {color: "windowText", textOutline: "none"}
                    },
                    marker: {lineColor: "windowText", fillColor: "windowText"}
                },
                pie: {color: "window", colors: ["window"], borderColor: "windowText", borderWidth: 1},
                boxplot: {fillColor: "window"},
                candlestick: {lineColor: "windowText", fillColor: "window"},
                errorbar: {fillColor: "window"}
            },
            legend: {
                backgroundColor: "window",
                itemStyle: {color: "windowText"},
                itemHoverStyle: {color: "windowText"},
                itemHiddenStyle: {color: "#555"},
                title: {style: {color: "windowText"}}
            },
            credits: {style: {color: "windowText"}},
            labels: {style: {color: "windowText"}},
            drilldown: {activeAxisLabelStyle: {color: "windowText"}, activeDataLabelStyle: {color: "windowText"}},
            navigation: {buttonOptions: {symbolStroke: "windowText", theme: {fill: "window"}}},
            rangeSelector: {
                buttonTheme: {
                    fill: "window",
                    stroke: "windowText",
                    style: {color: "windowText"},
                    states: {
                        hover: {fill: "window", stroke: "windowText", style: {color: "windowText"}},
                        select: {fill: "#444", stroke: "windowText", style: {color: "windowText"}}
                    }
                },
                inputBoxBorderColor: "windowText",
                inputStyle: {backgroundColor: "window", color: "windowText"},
                labelStyle: {color: "windowText"}
            },
            navigator: {
                handles: {backgroundColor: "window", borderColor: "windowText"},
                outlineColor: "windowText",
                maskFill: "transparent",
                series: {color: "windowText", lineColor: "windowText"},
                xAxis: {gridLineColor: "windowText"}
            },
            scrollbar: {
                barBackgroundColor: "#444",
                barBorderColor: "windowText",
                buttonArrowColor: "windowText",
                buttonBackgroundColor: "window",
                buttonBorderColor: "windowText",
                rifleColor: "windowText",
                trackBackgroundColor: "window",
                trackBorderColor: "windowText"
            }
        }
    });
    p(e, "modules/accessibility/options.js", [], function () {
        return {
            accessibility: {
                enabled: !0,
                pointDescriptionThreshold: 200,
                pointNavigationThreshold: !1,
                addTableShortcut: !0,
                axisRangeDateFormat: "%Y-%m-%d %H:%M:%S",
                describeSingleSeries: !1,
                landmarkVerbosity: "all",
                keyboardNavigation: {
                    enabled: !0,
                    skipNullPoints: !0,
                    focusBorder: {
                        enabled: !0,
                        hideBrowserFocusOutline: !0,
                        style: {color: "#335cad", lineWidth: 2, borderRadius: 3},
                        margin: 2
                    },
                    order: ["series", "zoom", "rangeSelector", "legend", "chartMenu"],
                    wrapAround: !0
                },
                announceNewData: {enabled: !1, minAnnounceInterval: 5E3, interruptUser: !1}
            },
            legend: {accessibility: {enabled: !0, keyboardNavigation: {enabled: !0}}},
            exporting: {accessibility: {enabled: !0}}
        }
    });
    p(e, "modules/accessibility/deprecatedOptions.js", [e["parts/Globals.js"], e["parts/Utilities.js"]], function (d, e) {
        function k(a, c, d) {
            g("Highcharts: Deprecated option " + c + " used. Use " + d + " instead.", !1, a)
        }

        function l(a) {
            var b = a.options.chart || {}, c = a.options.accessibility || {};
            ["description", "typeDescription"].forEach(function (d) {
                b[d] && (c[d] = b[d], k(a, "chart." + d, "accessibility." + d))
            })
        }

        function a(a) {
            a.axes.forEach(function (b) {
                (b = b.options) && b.description && (b.accessibility = b.accessibility || {}, b.accessibility.description =
                    b.description, k(a, "axis.description", "axis.accessibility.description"))
            })
        }

        function c(a) {
            var b = {
                description: ["accessibility", "description"],
                exposeElementToA11y: ["accessibility", "exposeAsGroupOnly"],
                pointDescriptionFormatter: ["accessibility", "pointDescriptionFormatter"],
                skipKeyboardNavigation: ["accessibility", "keyboardNavigation", "enabled"]
            };
            a.series.forEach(function (c) {
                Object.keys(b).forEach(function (d) {
                    var e = c.options[d];
                    if (void 0 !== e) {
                        var g = b[d];
                        e = "skipKeyboardNavigation" === d ? !e : e;
                        for (var m = c.options,
                                 l, n = 0; n < g.length - 1; ++n)l = g[n], m = m[l] = f(m[l], {});
                        m[g[g.length - 1]] = e;
                        k(a, "series." + d, "series." + b[d].join("."))
                    }
                });
                c.points && c.points.forEach(function (b) {
                    b.options && b.options.description && (b.options.accessibility = b.options.accessibility || {}, b.options.accessibility.description = b.options.description, k(a, "point.description", "point.accessibility.description"))
                })
            })
        }

        var f = e.pick, g = d.error;
        return function (b) {
            l(b);
            a(b);
            b.series && c(b)
        }
    });
    p(e, "modules/accessibility/a11y-i18n.js", [e["parts/Globals.js"], e["parts/Utilities.js"]],
        function (d, e) {
            function k(a, c) {
                var d = a.indexOf("#each("), e = a.indexOf("#plural("), b = a.indexOf("["), k = a.indexOf("]");
                if (-1 < d) {
                    b = a.slice(d).indexOf(")") + d;
                    var m = a.substring(0, d);
                    e = a.substring(b + 1);
                    b = a.substring(d + 6, b).split(",");
                    d = Number(b[1]);
                    a = "";
                    if (c = c[b[0]])for (d = isNaN(d) ? c.length : d, d = 0 > d ? c.length + d : Math.min(d, c.length), b = 0; b < d; ++b)a += m + c[b] + e;
                    return a.length ? a : ""
                }
                if (-1 < e) {
                    m = a.slice(e).indexOf(")") + e;
                    a = a.substring(e + 8, m).split(",");
                    switch (Number(c[a[0]])) {
                        case 0:
                            a = l(a[4], a[1]);
                            break;
                        case 1:
                            a = l(a[2],
                                a[1]);
                            break;
                        case 2:
                            a = l(a[3], a[1]);
                            break;
                        default:
                            a = a[1]
                    }
                    a ? (c = a, c = c.trim && c.trim() || c.replace(/^\s+|\s+$/g, "")) : c = "";
                    return c
                }
                return -1 < b ? (e = a.substring(0, b), a = Number(a.substring(b + 1, k)), c = c[e], !isNaN(a) && c && (0 > a ? (m = c[c.length + a], void 0 === m && (m = c[0])) : (m = c[a], void 0 === m && (m = c[c.length - 1]))), void 0 !== m ? m : "") : "{" + a + "}"
            }

            var l = e.pick;
            d.i18nFormat = function (a, c, e) {
                var f = function (a, b) {
                        a = a.slice(b || 0);
                        var c = a.indexOf("{"), d = a.indexOf("}");
                        if (-1 < c && d > c)return {statement: a.substring(c + 1, d), begin: b + c + 1, end: b + d}
                    },
                    b = [];
                var l = 0;
                do {
                    var m = f(a, l);
                    l = a.substring(l, m && m.begin - 1);
                    l.length && b.push({value: l, type: "constant"});
                    m && b.push({value: m.statement, type: "statement"});
                    l = m && m.end + 1
                } while (m);
                b.forEach(function (a) {
                    "statement" === a.type && (a.value = k(a.value, c))
                });
                return d.format(b.reduce(function (a, b) {
                    return a + b.value
                }, ""), c, e)
            };
            d.Chart.prototype.langFormat = function (a, c, e) {
                a = a.split(".");
                for (var f = this.options.lang, b = 0; b < a.length; ++b)f = f && f[a[b]];
                return "string" === typeof f && d.i18nFormat(f, c, e)
            };
            d.setOptions({
                lang: {
                    accessibility: {
                        screenReaderRegionLabel: "Chart screen reader information.",
                        defaultChartTitle: "Chart",
                        viewAsDataTable: "View as data table.",
                        chartHeading: "Chart graphic.",
                        chartContainerLabel: "{title}. Highcharts interactive chart.",
                        credits: "Chart credits: {creditsStr}",
                        svgContainerLabel: "Interactive chart",
                        rangeSelectorMinInput: "Select start date.",
                        rangeSelectorMaxInput: "Select end date.",
                        tableSummary: "Table representation of chart.",
                        mapZoomIn: "Zoom chart",
                        mapZoomOut: "Zoom out chart",
                        resetZoomButton: "Reset zoom",
                        drillUpButton: "{buttonText}",
                        rangeSelectorButton: "Select range {buttonText}",
                        legendLabel: "Toggle series visibility",
                        legendItem: "Toggle visibility of {itemName}",
                        thousandsSep: ",",
                        svgContainerTitle: "",
                        svgContainerEnd: "End of interactive chart",
                        announceNewData: {
                            newDataAnnounce: "Updated data for chart {chartTitle}",
                            newSeriesAnnounceSingle: "New data series: {seriesDesc}",
                            newPointAnnounceSingle: "New data point: {pointDesc}",
                            newSeriesAnnounceMultiple: "New data series in chart {chartTitle}: {seriesDesc}",
                            newPointAnnounceMultiple: "New data point in chart {chartTitle}: {pointDesc}"
                        },
                        seriesTypeDescriptions: {
                            boxplot: "Box plot charts are typically used to display groups of statistical data. Each data point in the chart can have up to 5 values: minimum, lower quartile, median, upper quartile, and maximum.",
                            arearange: "Arearange charts are line charts displaying a range between a lower and higher value for each point.",
                            areasplinerange: "These charts are line charts displaying a range between a lower and higher value for each point.",
                            bubble: "Bubble charts are scatter charts where each data point also has a size value.",
                            columnrange: "Columnrange charts are column charts displaying a range between a lower and higher value for each point.",
                            errorbar: "Errorbar series are used to display the variability of the data.",
                            funnel: "Funnel charts are used to display reduction of data in stages.",
                            pyramid: "Pyramid charts consist of a single pyramid with item heights corresponding to each point value.",
                            waterfall: "A waterfall chart is a column chart where each column contributes towards a total end value."
                        },
                        chartTypes: {
                            emptyChart: "Empty chart",
                            mapTypeDescription: "Map of {mapTitle} with {numSeries} data series.",
                            unknownMap: "Map of unspecified region with {numSeries} data series.",
                            combinationChart: "Combination chart with {numSeries} data series.",
                            defaultSingle: "Chart with {numPoints} data {#plural(numPoints, points, point)}.",
                            defaultMultiple: "Chart with {numSeries} data series.",
                            splineSingle: "Line chart with {numPoints} data {#plural(numPoints, points, point)}.",
                            splineMultiple: "Line chart with {numSeries} lines.",
                            lineSingle: "Line chart with {numPoints} data {#plural(numPoints, points, point)}.",
                            lineMultiple: "Line chart with {numSeries} lines.",
                            columnSingle: "Bar chart with {numPoints} {#plural(numPoints, bars, bar)}.",
                            columnMultiple: "Bar chart with {numSeries} data series.",
                            barSingle: "Bar chart with {numPoints} {#plural(numPoints, bars, bar)}.",
                            barMultiple: "Bar chart with {numSeries} data series.",
                            pieSingle: "Pie chart with {numPoints} {#plural(numPoints, slices, slice)}.",
                            pieMultiple: "Pie chart with {numSeries} pies.",
                            scatterSingle: "Scatter chart with {numPoints} {#plural(numPoints, points, point)}.",
                            scatterMultiple: "Scatter chart with {numSeries} data series.",
                            boxplotSingle: "Boxplot with {numPoints} {#plural(numPoints, boxes, box)}.",
                            boxplotMultiple: "Boxplot with {numSeries} data series.",
                            bubbleSingle: "Bubble chart with {numPoints} {#plural(numPoints, bubbles, bubble)}.",
                            bubbleMultiple: "Bubble chart with {numSeries} data series."
                        },
                        axis: {
                            xAxisDescriptionSingular: "The chart has 1 X axis displaying {names[0]}. {ranges[0]}",
                            xAxisDescriptionPlural: "The chart has {numAxes} X axes displaying {#each(names, -1) }and {names[-1]}.",
                            yAxisDescriptionSingular: "The chart has 1 Y axis displaying {names[0]}. {ranges[0]}",
                            yAxisDescriptionPlural: "The chart has {numAxes} Y axes displaying {#each(names, -1) }and {names[-1]}.",
                            timeRangeDays: "Range: {range} days.",
                            timeRangeHours: "Range: {range} hours.",
                            timeRangeMinutes: "Range: {range} minutes.",
                            timeRangeSeconds: "Range: {range} seconds.",
                            rangeFromTo: "Range: {rangeFrom} to {rangeTo}.",
                            rangeCategories: "Range: {numCategories} categories."
                        },
                        exporting: {
                            chartMenuLabel: "Chart menu", menuButtonLabel: "View chart menu",
                            exportRegionLabel: "Chart menu"
                        },
                        series: {
                            summary: {
                                "default": "{name}, series {ix} of {numSeries} with {numPoints} data {#plural(numPoints, points, point)}.",
                                defaultCombination: "{name}, series {ix} of {numSeries} with {numPoints} data {#plural(numPoints, points, point)}.",
                                line: "{name}, line {ix} of {numSeries} with {numPoints} data {#plural(numPoints, points, point)}.",
                                lineCombination: "{name}, series {ix} of {numSeries}. Line with {numPoints} data {#plural(numPoints, points, point)}.",
                                spline: "{name}, line {ix} of {numSeries} with {numPoints} data {#plural(numPoints, points, point)}.",
                                splineCombination: "{name}, series {ix} of {numSeries}. Line with {numPoints} data {#plural(numPoints, points, point)}.",
                                column: "{name}, bar series {ix} of {numSeries} with {numPoints} {#plural(numPoints, bars, bar)}.",
                                columnCombination: "{name}, series {ix} of {numSeries}. Bar series with {numPoints} {#plural(numPoints, bars, bar)}.",
                                bar: "{name}, bar series {ix} of {numSeries} with {numPoints} {#plural(numPoints, bars, bar)}.",
                                barCombination: "{name}, series {ix} of {numSeries}. Bar series with {numPoints} {#plural(numPoints, bars, bar)}.",
                                pie: "{name}, pie {ix} of {numSeries} with {numPoints} {#plural(numPoints, slices, slice)}.",
                                pieCombination: "{name}, series {ix} of {numSeries}. Pie with {numPoints} {#plural(numPoints, slices, slice)}.",
                                scatter: "{name}, scatter plot {ix} of {numSeries} with {numPoints} {#plural(numPoints, points, point)}.",
                                scatterCombination: "{name}, series {ix} of {numSeries}, scatter plot with {numPoints} {#plural(numPoints, points, point)}.",
                                boxplot: "{name}, boxplot {ix} of {numSeries} with {numPoints} {#plural(numPoints, boxes, box)}.",
                                boxplotCombination: "{name}, series {ix} of {numSeries}. Boxplot with {numPoints} {#plural(numPoints, boxes, box)}.",
                                bubble: "{name}, bubble series {ix} of {numSeries} with {numPoints} {#plural(numPoints, bubbles, bubble)}.",
                                bubbleCombination: "{name}, series {ix} of {numSeries}. Bubble series with {numPoints} {#plural(numPoints, bubbles, bubble)}.",
                                map: "{name}, map {ix} of {numSeries} with {numPoints} {#plural(numPoints, areas, area)}.",
                                mapCombination: "{name}, series {ix} of {numSeries}. Map with {numPoints} {#plural(numPoints, areas, area)}.",
                                mapline: "{name}, line {ix} of {numSeries} with {numPoints} data {#plural(numPoints, points, point)}.",
                                maplineCombination: "{name}, series {ix} of {numSeries}. Line with {numPoints} data {#plural(numPoints, points, point)}.",
                                mapbubble: "{name}, bubble series {ix} of {numSeries} with {numPoints} {#plural(numPoints, bubbles, bubble)}.",
                                mapbubbleCombination: "{name}, series {ix} of {numSeries}. Bubble series with {numPoints} {#plural(numPoints, bubbles, bubble)}."
                            }, description: "{description}", xAxisDescription: "X axis, {name}",
                            yAxisDescription: "Y axis, {name}"
                        }
                    }
                }
            })
        });
    p(e, "modules/accessibility/accessibility.js", [e["parts/Globals.js"], e["parts/Utilities.js"], e["modules/accessibility/KeyboardNavigationHandler.js"], e["modules/accessibility/AccessibilityComponent.js"], e["modules/accessibility/KeyboardNavigation.js"], e["modules/accessibility/components/LegendComponent.js"], e["modules/accessibility/components/MenuComponent.js"], e["modules/accessibility/components/SeriesComponent.js"], e["modules/accessibility/components/ZoomComponent.js"],
        e["modules/accessibility/components/RangeSelectorComponent.js"], e["modules/accessibility/components/InfoRegionComponent.js"], e["modules/accessibility/components/ContainerComponent.js"], e["modules/accessibility/high-contrast-mode.js"], e["modules/accessibility/high-contrast-theme.js"], e["modules/accessibility/options.js"], e["modules/accessibility/deprecatedOptions.js"]], function (d, e, k, l, a, c, f, g, b, n, m, p, t, h, r, y) {
        function q(a) {
            this.init(a)
        }

        var u = e.extend, z = e.pick, v = d.addEvent, A = d.win.document, x = d.merge;
        x(!0, d.defaultOptions, r, {accessibility: {highContrastTheme: h}});
        d.KeyboardNavigationHandler = k;
        d.AccessibilityComponent = l;
        u(d.SVGElement.prototype, {
            addFocusBorder: function (a, b) {
                this.focusBorder && this.removeFocusBorder();
                var c = this.getBBox();
                a = z(a, 3);
                c.x += this.translateX ? this.translateX : 0;
                c.y += this.translateY ? this.translateY : 0;
                this.focusBorder = this.renderer.rect(c.x - a, c.y - a, c.width + 2 * a, c.height + 2 * a, b && b.borderRadius).addClass("highcharts-focus-border").attr({zIndex: 99}).add(this.parentGroup);
                this.renderer.styledMode ||
                this.focusBorder.attr({stroke: b && b.stroke, "stroke-width": b && b.strokeWidth})
            }, removeFocusBorder: function () {
                this.focusBorder && (this.focusBorder.destroy(), delete this.focusBorder)
            }
        });
        d.Chart.prototype.setFocusToElement = function (a, b) {
            var c = this.options.accessibility.keyboardNavigation.focusBorder;
            (b = b || a.element) && b.focus && (b.hcEvents && b.hcEvents.focusin || v(b, "focusin", function () {
            }), b.focus(), c.hideBrowserFocusOutline && (b.style.outline = "none"));
            c.enabled && (this.focusElement && this.focusElement.removeFocusBorder(),
                a.addFocusBorder(c.margin, {
                    stroke: c.style.color,
                    strokeWidth: c.style.lineWidth,
                    borderRadius: c.style.borderRadius
                }), this.focusElement = a)
        };
        d.Axis.prototype.getDescription = function () {
            return this.userOptions && this.userOptions.accessibility && this.userOptions.accessibility.description || this.axisTitle && this.axisTitle.textStr || this.options.id || this.categories && "categories" || this.isDatetimeAxis && "Time" || "values"
        };
        q.prototype = {
            init: function (b) {
                this.chart = b;
                A.addEventListener && b.renderer.isSVG ? (y(b), this.initComponents(),
                    this.keyboardNavigation = new a(b, this.components), this.update()) : b.renderTo.setAttribute("aria-hidden", !0)
            }, initComponents: function () {
                var a = this.chart, d = a.options.accessibility;
                this.components = {
                    container: new p,
                    infoRegion: new m,
                    legend: new c,
                    chartMenu: new f,
                    rangeSelector: new n,
                    series: new g,
                    zoom: new b
                };
                d.customComponents && u(this.components, d.customComponents);
                var e = this.components;
                Object.keys(e).forEach(function (b) {
                    e[b].initBase(a);
                    e[b].init()
                })
            }, update: function () {
                var a = this.components, b = this.chart, c =
                    b.options.accessibility;
                b.types = this.getChartTypes();
                Object.keys(a).forEach(function (b) {
                    a[b].onChartUpdate()
                });
                this.keyboardNavigation.update(c.keyboardNavigation.order);
                !b.highContrastModeActive && t.isHighContrastModeActive(b) && t.setHighContrastTheme(b)
            }, destroy: function () {
                var a = this.chart || {}, b = this.components;
                Object.keys(b).forEach(function (a) {
                    b[a].destroy();
                    b[a].destroyBase()
                });
                this.keyboardNavigation && this.keyboardNavigation.destroy();
                a.renderTo && a.renderTo.setAttribute("aria-hidden", !0);
                a.focusElement &&
                a.focusElement.removeFocusBorder()
            }, getChartTypes: function () {
                var a = {};
                this.chart.series.forEach(function (b) {
                    a[b.type] = 1
                });
                return Object.keys(a)
            }
        };
        d.Chart.prototype.updateA11yEnabled = function () {
            var a = this.accessibility, b = this.options.accessibility;
            b && b.enabled ? a ? a.update() : this.accessibility = new q(this) : a ? (a.destroy && a.destroy(), delete this.accessibility) : this.renderTo.setAttribute("aria-hidden", !0)
        };
        v(d.Chart, "render", function (a) {
            this.a11yDirty && this.renderTo && (delete this.a11yDirty, this.updateA11yEnabled());
            var b = this.accessibility;
            b && Object.keys(b.components).forEach(function (c) {
                b.components[c].onChartRender(a)
            })
        });
        v(d.Chart, "update", function (a) {
            if (a = a.options.accessibility) a.customComponents && (this.options.accessibility.customComponents = a.customComponents, delete a.customComponents), x(!0, this.options.accessibility, a), this.accessibility && this.accessibility.destroy && (this.accessibility.destroy(), delete this.accessibility);
            this.a11yDirty = !0
        });
        v(d.Point, "update", function () {
            this.series.chart.accessibility &&
            (this.series.chart.a11yDirty = !0)
        });
        ["addSeries", "init"].forEach(function (a) {
            v(d.Chart, a, function () {
                this.a11yDirty = !0
            })
        });
        ["update", "updatedData", "remove"].forEach(function (a) {
            v(d.Series, a, function () {
                this.chart.accessibility && (this.chart.a11yDirty = !0)
            })
        });
        ["afterDrilldown", "drillupall"].forEach(function (a) {
            v(d.Chart, a, function () {
                this.accessibility && this.accessibility.update()
            })
        });
        v(d.Chart, "destroy", function () {
            this.accessibility && this.accessibility.destroy()
        })
    });
    p(e, "masters/modules/accessibility.src.js",
        [], function () {
        })
});
//# sourceMappingURL=accessibility.js.map