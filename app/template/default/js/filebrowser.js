! function(a, b, c, d) {
    "use strict";

    function e(b, c) {
        this.element = b, this.$element = a(b), this.name = f, this.opts = a.extend(!0, {}, a.fn[f].defaults, c), this.$elements = {
            breadcrumbs: null,
            content: null
        };
        this.init(b, c)
    }
    var f = "fileBrowser";
    e.prototype = {
        _get: function() {
            var b = this;
            if (b.opts.json) {
                var c = jQuery.Deferred();
                return c.resolve(b.opts.json[b._pathToString()]), c.promise()
            }
            var d = b.opts.data;
            return d.path = b._pathToString(), a.ajax({
                url: b.opts.url,
                dataType: "json",
                type: b.opts.method,
                async: !0,
                cache: !1,
                data: d
            })
        },
        _awesome: function(a) {
            var b = "";
            switch (a) {
                case "folder":
                    b = "fa fa-folder";
                    break;
                case "ogg":
                case "wav":
                case "mp3":
                    b = "fa fa-file-audio-o";
                    break;
                case "docx":
                case "doc":
                case "odt":
                    b = "fa fa-file-word-o";
                    break;
                case "xls":
                    b = "fa fa-file-excel-o";
                    break;
                case "pps":
                    b = "fa fa-file-powerpoint-o";
                    break;
                case "tiff":
                case "gif":
                case "bmp":
                case "png":
                case "jpeg":
                case "jpg":
                    b = "fa fa-file-image-o";
                    break;
                case "gz":
                case "tar":
                case "rar":
                case "zip":
                    b = "fa fa-file-archive-o";
                    break;
                case "mpg":
                case "avi":
                case "mp4":
                case "flv":
                    b = "fa fa-archive-o";
                    break;
                case "pdf":
                    b = "fa fa-pdf-o";
                    break;
                case "txt":
                case "sql":
                case "php":
                case "css":
                case "js":
                case "config":
                    b = "fa fa-file-text-o";
                    break;
                default:
                    b = "fa fa-file-o"
            }
            return b
        },
        _trim: function(a, b, c) {
            return b === d && (b = "s"), c === d && (c = "both"), ("left" == c || "both" == c) && (a = a.replace(new RegExp("^[" + b + "]+"), "")), ("right" == c || "both" == c) && (a = a.replace(new RegExp("[" + b + "]+$"), "")), a
        },
        _pathChange: function(a) {
            var b = this;
            a != d && (".." == a ? b.path.pop() : b.path.push(a))
        },
        _pathToString: function(a) {
            var b = this;
            if (a == d) var c = b.path;
            else var c = b.path.slice(0, a);
            var e = 1 == c.length ? "/" : c.join("/");
            return e
        },
        _draw: function(b) {
            var c = this;
            c.$elements.content.html(""), c.$element.removeClass("x32 x22 x16"), c.$element.addClass("x" + c.opts.size), c.$elements.content.removeClass("icon details"), c.$elements.content.addClass(c.opts.view), c.opts.breadcrumbs && (c.$elements.breadcrumbs.html(""), a.each(c.path, function(b, d) {
                var e = "" == d ? "/var/www/html" : d,
                    f = a("<li />").data("path", c._pathToString(b + 1)).text(e);
                c.$elements.breadcrumbs.append(f)
            }));
            var d = "<ul>";
            a.each(b, function(a, b) {
                d += '<li data-name="' + b.name + '" data-type="' + ("folder" == b.type ? "folder" : "file") + '"><i class="' + c._awesome(b.type) + '"></i><span>' + (b.name || "") + "</span></li>"
            }), d += "</ul>", c.$elements.content.html(d)
        },
        init: function() {
            var b = this;
            b.path = b._trim(this.opts.path, "/", "right").split("/"), b.$element.html(""), b.$element.addClass("fm"), 1 == b.opts.breadcrumbs && (b.$elements.breadcrumbs = a("<ul />").addClass("fmBreadCrumbs"), b.$element.append(b.$elements.breadcrumbs), b.$elements.breadcrumbs.on("click", "li", function() {
                var c = a(this);
                b.path = b._trim(c.data("path"), "/", "right").split("/"), b._get().then(function(a) {
                    b._draw(a)
                })
            })), b.$elements.content = a("<div />").addClass("fmContent"), b.$element.append(b.$elements.content);
            var c = function(a) {
                    "folder" == a.data("type") && (b._pathChange(a.data("name")), b._get().then(function(a) {
                        b._draw(a)
                    })), b.opts.onOpen.call(b, b, a.data("name"), b._pathToString(), a.data("type"))
                },
                d = function(a) {
                    ".." != a.data("name") && (b.$elements.content.find("li").removeClass("selected"), a.addClass("selected"), b.selected = b._pathToString() + a.data("name"), b.opts.onSelect.call(b, b, a.data("name"), b._pathToString(), a.data("type")))
                },
                e = 0,
                f = 1;
            b.opts.select ? 2 : 1;
            b.$elements.content.on("click", "li", function() {
                var g = a(this);
                e++, 1 === e ? f = setTimeout(function() {
                    b.opts.select ? d(g) : c(g), e = 0
                }, 200) : (clearTimeout(f), b.opts.select && d(g), c(g), e = 0)
            }), b._get().then(function(a) {
                b._draw(a), b.opts.onLoad.call(b, b)
            })
        },
        remove: function() {
            this.html(""), this.$element.removeData("plugin_" + f), this.$element.removeClass("fm x32 x22 x16")
        },
        getSelected: function() {
            var a = this;
            return a.selected
        },
        getPath: function() {
            var a = this;
            return a._pathToString()
        },
        redraw: function() {
            var a = this;
            a._get().then(function(b) {
                a._draw(b)
            })
        },
        chgOption: function(a) {
            var b = this;
            "undefined" != typeof a.view && (b.opts.view = a.view), "undefined" != typeof a.size && (b.opts.size = a.size), "undefined" != typeof a.select && (b.opts.select = a.select), "undefined" != typeof a.path && (b.path = b._trim(a.path, "/", "right").split("/")), b.redraw()
        }
    }, a.fn[f] = function(b) {
        if ("string" == typeof arguments[0]) {
            var c = Array.prototype.slice.call(arguments, 1);
            if (a.isFunction(e.prototype[b])) {
                var d;
                return this.each(function() {
                    d = a.data(this, "plugin_" + f)[b](c[0])
                }), "undefined" != typeof d ? d : this
            }
            a.error("Method " + b + " is not available")
        }
        else if ("object" == typeof b || !b) return this.each(function() {
            a.data(this, "plugin_" + f) || a.data(this, "plugin_" + f, new e(this, b))
        })
    }, a.fn[f].defaults = {
        url: "",
        json: null,
        method: "post",
        view: "details",
        size: "32",
        path: "/",
        breadcrumbs: !1,
        select: !0,
        data: {},
        onSelect: function() {},
        onOpen: function() {},
        onDestroy: function() {},
        onLoad: function() {}
    }
}(jQuery, window, document);
