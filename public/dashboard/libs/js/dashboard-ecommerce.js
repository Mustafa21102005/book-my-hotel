chart.on("draw", function (data) {
    if (data.type === "slice") {
        // Get the total path length in order to use for dash array animation
        var pathLength = data.element._node.getTotalLength();

        // Set a dasharray that matches the path length as prerequisite to animate dashoffset
        data.element.attr({
            "stroke-dasharray": pathLength + "px " + pathLength + "px",
        });

        // Create animation definition while also assigning an ID to the animation for later sync usage
        var animationDefinition = {
            "stroke-dashoffset": {
                id: "anim" + data.index,
                dur: 1000,
                from: -pathLength + "px",
                to: "0px",
                easing: Chartist.Svg.Easing.easeOutQuint,
                // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                fill: "freeze",
            },
        };

        // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
        if (data.index !== 0) {
            animationDefinition["stroke-dashoffset"].begin =
                "anim" + (data.index - 1) + ".end";
        }

        // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
        data.element.attr({
            "stroke-dashoffset": -pathLength + "px",
        });

        // We can't use guided mode as the animations need to rely on setting begin manually
        // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
        data.element.animate(animationDefinition, false);
    }
});

// For the sake of the example we update the chart every time it's created with a delay of 8 seconds

// ==============================================================
// Customer acquisition
// ==============================================================
var chart = new Chartist.Line(
    ".ct-chart",
    {
        labels: ["Mon", "Tue", "Wed"],
        series: [
            [1, 5, 2, 5],
            [2, 3, 4, 8],
        ],
    },
    {
        low: 0,
        showArea: true,
        showPoint: false,
        fullWidth: true,
    },
);

chart.on("draw", function (data) {
    if (data.type === "line" || data.type === "area") {
        data.element.animate({
            d: {
                begin: 2000 * data.index,
                dur: 2000,
                from: data.path
                    .clone()
                    .scale(1, 0)
                    .translate(0, data.chartRect.height())
                    .stringify(),
                to: data.path.clone().stringify(),
                easing: Chartist.Svg.Easing.easeOutQuint,
            },
        });
    }
});
