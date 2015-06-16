(function ( $ ) {


    function Typeahead(element, options) {

        this.$element = $(element);
        this.options = $.extend({}, $.fn.typeahead.defaults, options);
        this.$menu = $(this.options.menu);
        this.$input = $(this.options.input);
        this.ajaxRequest = null;


        if(typeof(this.options.url) === "undefined" || this.options.url == null) {
            alert("Error: url property not defined");
            return;
        }

        this.listen();

    };

    Typeahead.prototype =
    {
        constructor: Typeahead,

        listen:function() {
            this.$element.on("keyup", $.proxy(this.keyup, this));
            this.$element.on("focus", $.proxy(this.focus, this));
            this.$element.on("blur", $.proxy(this.blur, this));

            this.$menu.on("click", "a", this.handleClick);
            this.$menu.on("click", "a", $.proxy(this.clickItem, this));

        },

        focus:function() {
            if(this.$element.val()!="") {
                this.findItems();
            }
        },

        blur:function() {
            var that=this;
            setTimeout(
                function(){
                    that.$menu.hide()
                },
                100
            );
        },

        keyup:function() {

            this.cancelAjaxRequest();
            if(this.$element.val()=="") {
                this.blur();
            }
            else this.findItems();

        },
        findItems:function() {
            var filter = this.$element.val();
            this.ajaxRequest = $.get(this.options.url, {"filter":filter}, $.proxy(this.handleItems, this), "json");
        },
        handleItems:function(data) {


            this.$menu.html('');
            var parentObj = this;

            if(data.length > 0) {
                var i = 0;
                var limit = this.options.limit;
                $.each(data, function (i, val) {
                    var $item = $(parentObj.options.item);
                    $item.find('a').text(val[parentObj.options.stringAttribute]);
                    $item.find('a').attr("data-id", val[parentObj.options.idAttribute]);
                    parentObj.$menu.append($item);
                    i++;
                    if(i >= limit) {
                        return false;
                    }

                });

                this.$element.after(this.$menu);
                this.$menu.parent().css({"position": "relative"});
                this.$menu.show();
            }
            else this.blur();

        },

        cancelAjaxRequest:function() {
            if(this.ajaxRequest != null) {
                this.ajaxRequest.abort();
                this.ajaxRequest = null;
            }
        },

        clickItem:function(e) {
            var that = this;
            e.preventDefault();
            setTimeout(
                function() {
                    var itemElement = that.$menu.find('a.active');
                    var id =itemElement.attr('data-id');
                    that.$input.val(id);
                    that.$menu.after(that.$input);
                    that.$element.val(itemElement.text());
                },
                100
            );
        },

        handleClick:function(e) {
            e.preventDefault();
            $(this).parent().find('a').removeClass('active')
            $(this).addClass('active');
        }
    };

    $.fn.typeahead = function( options ) {

        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            limit:10,
            menu: '<ul class="typeahead dropdown-menu" role="listbox"></ul>',
            item: '<li><a href="#" role="option"></a></li>',
            input: '<input type="hidden" name="typeahead" value="off">',
            stringAttribute: 'name',
            idAttribute: 'id'


        }, options );


        // Greenify the collection based on the settings variable.
        return this.each(function() {
            new Typeahead(this, settings);
        });

    };

}( jQuery ));