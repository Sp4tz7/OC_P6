(function ($) {

    /////////////////////
    // MAIN ENTRY POINT
    /////////////////////

    var Timeframe = function (selector) {
        var element = $(selector);

        var timeline = new Timeline(element);
        return timeline;
    };
    window.Timeframe = Timeframe;

    var defaultOptions = {
        tickHeight: 8,
        textHeight: 10
    };

    ///////////////////
    // TIMELINE CLASS
    ///////////////////

    var Timeline = function (container) {
        this.container = container;
        this.categories = [];

        this.options = {};
        for (var i in defaultOptions) {
            this.options[i] = defaultOptions[i];
        }

        this.outerWidth = this.container.innerWidth();
        this.outerHeight = 150;
        this.paddingX = 20;
        this.paddingY = 20;

        this.width = this.outerWidth - (this.paddingX * 2);
        this.height = this.outerHeight - (this.paddingY * 2);

        this.container.height(this.outerHeight);

        this.svg = $(svg("svg"))
            .attr("width", this.outerWidth)
            .attr("height", this.outerHeight)
            .appendTo(this.container);
    };

    // Configuration

    Timeline.prototype.start = function (startString) {
        this.startDate = parseDateString(startString);
        return this;
    };

    Timeline.prototype.end = function (endString) {
        this.endDate = parseDateString(endString);
        return this;
    };

    Timeline.prototype.majorTicks = function (number, type) {
        this.options.majorTicks = this.options.majorTicks || {};
        this.options.majorTicks.number = number;
        this.options.majorTicks.type = type;
        return this;
    };

    Timeline.prototype.minorTicks = function (number, type) {
        this.options.minorTicks = this.options.minorTicks || {};
        this.options.minorTicks.number = number;
        this.options.minorTicks.type = type;
        return this;
    };

    Timeline.prototype.autoTicks = function () {
        //TODO: look at the range of dates and adjust accordingly
        this.majorTicks(1, "years");
        this.minorTicks(1, "year");
        return this;
    };

    // Adding items

    Timeline.prototype.addCategory = function (categoryData) {
        console.log("addCategory", categoryData);

        var category = {
            name: categoryData.name,
            color: categoryData.color,
            events: [],
            spans: []
        };
        this.categories.push(category);

        if (categoryData.events && categoryData.events.length) {
            for (var e = 0; e < categoryData.events.length; e++) {
                var event = categoryData.events[e];
                this.addEvent(event, category);
            }
        }

        if (categoryData.spans && categoryData.spans.length) {
            for (var s = 0; s < categoryData.spans.length; s++) {
                var span = categoryData.spans[s];
                this.addSpan(span, category);
            }
        }

        return this;
    };

    Timeline.prototype.addEvent = function (eventData, category) {
        var event = {
            name: eventData.name,
            program: eventData.program,
            date: parseDateString(eventData.date),
            isProject: eventData.isProject,
            isCurrentProject: eventData.isCurrentProject,
            category: eventData.category,
            slug: eventData.slug
        };
        category.events.push(event);
    };

    Timeline.prototype.addSpan = function (spanData, category) {
        var span = {
            name: spanData.name,
            start: parseDateString(spanData.start),
            end: parseDateString(spanData.end)
        };
        category.spans.push(span);
    };

    // Rendering

    Timeline.prototype.draw = function () {

        //Prepare to draw first...
        if (!this.options.majorTicks || !this.options.minorTicks) {
            this.autoTicks();
        }

        this.drawBackground();
        this.drawItems();

        return this;
    };

    Timeline.prototype.drawBackground = function () {

        var background = $svg.group()
            .attr("class", "background")
            .appendTo(this.svg);

        var tickHeight = this.options.tickHeight;
        var textHeight = this.options.textHeight;

        var bottomLine = $svg.line(
            this.paddingX,
            this.height + this.paddingY - textHeight - tickHeight - 0.5,
            this.width + this.paddingX,
            this.height + this.paddingY - textHeight - tickHeight - 0.5
        )
            .attr("stroke", "#f6e8e5")
            .attr("stroke-width", 3)
            .appendTo(background);
/*
        var polygon = $svg.polygon(
10,10,
            '2952.56 13.18 35.69 13.18 30.04 6.58 35.69 0.18 2952.56 0.18 2958.56 6.5 2952.56 13.18'
        )
            .attr("class", 'cls-1')
            .appendTo(background);
        var polygon = $svg.polygon(
10,10,
            '21.77 6.58 28.04 0 21.57 0 18.38 3.19 18.38 3.19 15 6.58 18.38 9.96 18.38 9.96 21.04 13 28.04 13 21.77 6.58 21.77 6.58'
        )
            .attr("class", 'cls-1')
            .appendTo(background);
        var polygon = $svg.polygon(
10,10,
            '6.77 6.58 13.04 0 6.58 0 3.38 3.19 3.38 3.19 0 6.58 3.38 9.96 3.38 9.96 6.04 13 13.04 13 6.77 6.58 6.77 6.58'
        )
            .attr("class", 'cls-1')
            .appendTo(background);
        var polygon = $svg.polygon(
10,10,
            '2966.45 6.42 2960.18 13 2966.64 13 2969.84 9.81 2969.84 9.81 2973.22 6.42 2969.84 3.04 2969.84 3.04 2967.18 0 2960.18 0 2966.45 6.42 2966.45 6.42'
        )
            .attr("class", 'cls-1')
            .appendTo(background);
        var polygon = $svg.polygon(
10,10,
            '2981.45 6.42 2975.18 13 2981.64 13 2984.84 9.81 2984.84 9.81 2988.22 6.42 2984.84 3.04 2984.84 3.04 2982.18 0 2975.18 0 2981.45 6.42 2981.45 6.42'
        )
            .attr("class", 'cls-1')
            .appendTo(background);
*/
        //Draw the labels and ticks for each year
        for (var year = this.startDate.getFullYear(); year <= this.endDate.getFullYear(); year++) {
            var yearDate = new Date(year, 0, 1);
            var x = Math.floor(this.getX(yearDate)) + 0.5;

            var isMajorTick = (year % this.options.majorTicks.number === 0);
            var correction = (this.width/6)/2;
            if (isMajorTick) {
                var yearLabel = $svg.text(
                    x+correction,
                    this.height + this.paddingY,
                    year.toString().substring(2, 4),
                    {
                        fill: "#f6e8e5",
                        "font-size": "14",
                        "text-anchor": "middle"
                    }
                )
                    .appendTo(background);
            }

            var yearTick = $svg.line(
                x,
                this.height + this.paddingY - textHeight - tickHeight,
                x,
                this.height + this.paddingY - textHeight
            )
                .attr("stroke", "#f6e8e5")
                .attr("stroke-width", 1)
                .appendTo(background);
        }

        return this;
    };

    Timeline.prototype.drawItems = function () {
        for (var c = 0; c < this.categories.length; c++) {
            var category = this.categories[c];

            for (var e = 0; e < category.events.length; e++) {
                this.drawEvent(category.events[e]);
            }

            for (var s = 0; s < category.spans.length; s++) {
                this.drawSpan(category.spans[s]);
            }
        }
        return this;
    };

    Timeline.prototype.drawEvent = function (event) {
        var x = this.getX(event.date);
        var event_class = 'event';
        if (event.isProject == 1){
            var event_class = 'project-event';
        }
        var group = $svg.group()
            .attr("class", event_class)
            .appendTo(this.svg);
        var random = Math.floor(Math.random() * 80);

        const radius = 5;
        const fill = "#f6e8e5";
        const stroke = "black";
        const strokewidth = "2";

        const position = this.height - this.options.textHeight - this.options.tickHeight + this.paddingY - random;

        var attr = '';
        if (event.isCurrentProject == 1) {
            attr = 'current-event';
        } else {
            attr = 'timeline-event';
        }

        var circle2 = $svg.circle(
            x, position, "10.33"
        )
            .attr("class", attr+ ' selected cls-1')
            .appendTo(group);
        var circle3 = $svg.circle(
            x, position, "8.75"
        )
            .attr("class", attr+ ' selected cls-2')
            .appendTo(group);
        var line = $svg.line(
            x, position - 10.52, x
        )
            .attr("class", attr+ ' selected cls-3')
            .appendTo(group);


        var circle = $svg.circle(
            x,
            position,
            radius
        )
            .attr("fill", fill)
            .attr("stroke", stroke)
            .attr("stroke-width", strokewidth)
            .appendTo(group);



        var label = $svg.text(
            x+5,
            10,
              event.name,
            {
                fill: "#f6e8e5",
                "font-size": "14",
                "font-weight": "bold",
                "text-anchor": "left",
                'category': event.category,
                'slug': event.slug
            }
        )
            .attr("class", attr)
            .appendTo(group);

        var label2 = $svg.text(
            x+5,
            25,
                event.program ,
            {
                fill: "#f6e8e5",
                "font-size": "12",
                "text-anchor": "left",
                'category': event.category,
                'slug': event.slug
            }
        )
            .attr("class", attr)
            .appendTo(group);
    };

    Timeline.prototype.drawSpan = function (span) {
        console.log("drawSpan", span);

        var startX = this.getX(span.start);
        var endX = this.getX(span.end);

        var group = $svg.group()
            .attr("class", "span")
            .appendTo(this.svg);

        var rect = $svg.rect(
            startX,
            this.height - this.options.textHeight - this.options.tickHeight + this.paddingY - 4,
            endX - startX,
            7,
            {
                rx: 5,
                ry: 5
            }
        )
            .attr("fill", "#f6e8e5")
            .appendTo(group);

        var label = $svg.text(
            (startX + endX) / 2,
            this.height - this.options.textHeight - this.options.tickHeight + this.paddingY - 8,
            span.name,
            {
                fill: "#f6e8e5",
                "font-size": "12",
                "text-anchor": "middle"
            }
        )
            .appendTo(group);
    };

    // Utilities

    Timeline.prototype.getX = function (date) {
        var dateValue = date.valueOf();
        var start = this.startDate.valueOf();
        var end = this.endDate.valueOf();
        var x = ((dateValue - start) / (end - start) * this.width) + this.paddingX;
        return x;
    };

    ////////////
    // HELPERS
    ////////////

    var parseDateString = function (dateString) {
        //TODO: make this more robust
        var pieces = dateString.split("-");

        var years = parseInt(pieces[0], 10);
        var months = parseInt(pieces[1], 10) - 1;	//months are 0-based
        var days = parseInt(pieces[2], 10);

        var date = new Date(years, months, days);
        return date;
    };

    var $svg = {};

    $svg.group = function () {
        var element = $(svg("g"));
        return element;
    };

    $svg.line = function (x1, y1, x2, y2, options) {
        var element = $(svg("line"))
            .attr("x1", x1)
            .attr("y1", y1)
            .attr("x2", x2)
            .attr("y2", y2);
        setSvgOptions(element, options);
        return element;
    };

    $svg.circle = function (cx, cy, r, options) {
        var element = $(svg("circle"))
            .attr("cx", cx)
            .attr("cy", cy)
            .attr("r", r);
        setSvgOptions(element, options);
        return element;
    };

    $svg.rect = function (x, y, width, height, options) {
        var element = $(svg("rect"))
            .attr("x", x)
            .attr("y", y)
            .attr("width", width)
            .attr("height", height);
        setSvgOptions(element, options);
        return element;
    };

    $svg.polygon = function (x, y, points, options) {
        var element = $(svg("polygon"))
            .attr("x", x)
            .attr("y", y)
            .attr("cx", x)
            .attr("cy", y)
            .attr("points", points)
        setSvgOptions(element, options);
        return element;
    };

    $svg.text = function (x, y, text, options) {
        var element = $(svg("text"))
            .attr("x", x)
            .attr("y", y)
            .text(text);
        setSvgOptions(element, options);
        return element;
    };

    function svg(tagName) {
        return document.createElementNS('http://www.w3.org/2000/svg', tagName);
    }

    function setSvgOptions(element, options) {
        if (options) {
            for (var i in options) {
                element.attr(i, options[i]);
            }
        }
    }

})(jQuery);
