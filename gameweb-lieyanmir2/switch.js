(function ($) {
    function tipclass(ele, opt) {
        this.opt = opt;
        this.ele = $(ele);
    };
    tipclass.prototype.init = function () {
        var self = this;
        this.ele.css({ "position": "relative" });
        var runCen = this.ele.find(".runContent");
        this.item = runCen.children().size();
        var handle = null;
        if (self.opt.direction == "join") {
            runCen.children(":eq(0)").clone().appendTo(runCen);
        }
        if (this.opt.handle) {
            handle = $(this.opt.handle);
            handle.children().eq(0).addClass("cur");
        }
        if (self.opt.direction == "alpha") {
            runCen.children().eq(0).show().siblings().hide();
        }
        if (this.item > 1) {
            this.bindEven(runCen, handle);
        }
    };
    tipclass.prototype.bindEven = function (runCen, handle) {
        var self = this;
        var p = 1;
        var cunRun = true;
        var Go = null;
        if (self.opt.direction != "alpha") {
            var moveRange;
            runCen.css({ "left": "0", "position": "absolute", "top": "0" });
            if (self.opt.direction == "top") {
                moveRange = self.opt.height;
            } else if (self.opt.direction == "left") {
                runCen.width(this.opt.width * this.item);
                moveRange = self.opt.width;
            } else if (self.opt.direction == "join") {
                runCen.width(this.opt.width * (parseInt(this.item, 10) + 1));
                moveRange = self.opt.width;
            }
        }
        function readyGo() {
            runCen.stop();
            if (self.opt.direction == "join") {
                if (p == self.item) {
                    p++;
                    runCen.animate({ left: "-" + (p - 1) * moveRange + "px" }, self.opt.moveInterval, function () {
                        runCen.css({ "left": "0" });
                    });
                    p = 1;
                } else {
                    p++;
                    runCen.animate({ left: "-" + (p - 1) * moveRange + "px" }, self.opt.moveInterval, function () {
                    });
                }
                if (handle) {
                    handle.children().removeClass("cur").eq(p - 1).addClass("cur");
                }
            } else {
                p < self.item ? p++ : p = 1;
                if (self.opt.direction == "alpha") {
                    runCen.children(":visible").fadeOut(self.opt.moveInterval, function () {
                        if (handle) {
                            handle.children().removeClass("cur").eq(p - 1).addClass("cur");
                        }
                        runCen.children().eq(p - 1).fadeIn(self.opt.moveInterval, function () {
                        });
                    });
                } else {
                    if (handle) {
                        handle.children().removeClass("cur").eq(p - 1).addClass("cur");
                    }
                    if (self.opt.direction == "left") {
                        runCen.animate({ left: "-" + (p - 1) * moveRange + "px" }, self.opt.moveInterval, function () {
                        });
                    } else if (self.opt.direction == "top") {
                        runCen.animate({ top: "-" + (p - 1) * moveRange + "px" }, self.opt.moveInterval, function () {
                        });
                    }
                }
            }
            if (self.opt.playTitle) {
                var title = runCen.find("li").eq(p - 1).find("img").attr("alt");
                self.ele.find(self.opt.playTitle).html(title);
            }
        }
        Go = setInterval(readyGo, self.opt.interval);
        this.ele.hover(function () {
            clearInterval(Go);
        }, function () {
            Go = setInterval(readyGo, self.opt.interval);
        });
        if (handle) {
            handle.find("li").unbind("click").bind("click", function () {
                clearInterval(Go);
                p = $(this).index();
                readyGo();
                //  Go = setInterval(readyGo,self.opt.interval);
                return false;
            });
        }
        if (this.opt.arrow) {
            $("." + this.opt.arrow.left).unbind("click").bind("click", function () {
                clearInterval(Go);
                if (p > 1) {
                    p = p - 2;
                    readyGo();
                }
                return false;
            });
            $("." + this.opt.arrow.right).unbind("click").bind("click", function () {
                clearInterval(Go);
                if (p < self.item) {
                    readyGo();
                }
                return false;
            });
        }
    };
    $.fn.Switch = function (options) {
        var options = $.extend({
            width: 233,
            height: 388,
            moveInterval: 300,
            interval: 5000,
            direction: "alpha", //top or left or alpha or join
            handle: null,
            arrow: null,
            playTitle: null
        }, options);
        return this.each(function () {
            var obj = new tipclass(this, options);
            obj.init();
        });
    };
})(jQuery);