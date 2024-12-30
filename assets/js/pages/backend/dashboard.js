var _CreateBarChart = function(element, bardata, barQty, height, animate, easing, duration, delay, color) {
	if(element) {
	  var d3Container = d3.select(element),
	      width = d3Container.node().getBoundingClientRect().width;

	  var x = d3.scale.ordinal().rangeBands([0, width], 0.3);
	  var y = d3.scale.linear().range([0, height]);

	  x.domain(d3.range(0, bardata.length));
	  y.domain([0, d3.max(bardata)]);

	  var container = d3Container.append('svg');
	  var svg = container.attr('width', width).attr('height', height).append('g');

	  var bars = svg.selectAll('rect').data(bardata).enter().append('rect').attr('class', 'd3-random-bars').attr('width', x.rangeBand()).attr('x', function(d,i) { return x(i); }).style('fill', color);
	  var tip = d3.tip().attr('class', 'd3-tip').offset([-10, 0]);

	  bars.call(tip).on('mouseover', tip.show).on('mouseout', tip.hide);
	  tip.html(function (d) {
	    return "<div class='text-center'>" +
	            "<h6 class='mb-0'>" + d + "</h6>" +
	            "<span class='font-size-sm'>New User</span>" +
	        "</div>";
	  });

	  bars.attr('height', 0).attr('y', height).transition().attr('height', function(d) { return y(d); }).attr('y', function(d) { return height - y(d); }).delay(function(d, i) { return i * delay; }).duration(duration).ease(easing);

	  window.addEventListener('resize', barsResize);

	  var sidebarToggle = document.querySelector('.sidebar-control');
	  sidebarToggle && sidebarToggle.addEventListener('click', barsResize);

	  function barsResize() {
	    width = d3Container.node().getBoundingClientRect().width;
	    container.attr("width", width);
	    svg.attr("width", width);
	    x.rangeBands([0, width], 0.3);
	    svg.selectAll('.d3-random-bars').attr('width', x.rangeBand()).attr('x', function(d,i) { return x(i); });
	  }
	}
};

var _CreateAreaChart = function(element, data, chartHeight, color) {
  if(element) {
    var d3Container = d3.select(element),
        margin = {top: 0, right: 0, bottom: 0, left: 0},
        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
        height = chartHeight - margin.top - margin.bottom;

    var parseDate = d3.time.format('%Y-%m-%d').parse;
    var container = d3Container.append('svg');
    var svg = container.attr('width', width + margin.left + margin.right).attr('height', height + margin.top + margin.bottom).append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var area = d3.svg.area().x(function(d) { return x(d.date); }).y0(height).y1(function(d) { return y(d.value); }).interpolate('monotone');

    var x = d3.time.scale().range([0, width ]);
    var y = d3.scale.linear().range([height, 0]);

    data.forEach(function (d) {
        d.date = parseDate(d.date);
        d.value = +d.value;
    });

    var maxY = d3.max(data, function(d) { return d.value; });

    var startData = data.map(function(datum) {
        return {
            date: datum.date,
            value: 0
        };
    });

    x.domain(d3.extent(data, function(d, i) { return d.date; }));
    y.domain([0, d3.max( data, function(d) { return d.value; })]);

    svg.append("path").datum(data).attr("class", "d3-area").style('fill', color).attr("d", area).transition().duration(1000)
    .attrTween('d', function() {
        var interpolator = d3.interpolateArray(startData, data);
        return function (t) {
            return area(interpolator (t));
        };
    });

    window.addEventListener('resize', messagesAreaResize);

    var sidebarToggle = document.querySelector('.sidebar-control');
    sidebarToggle && sidebarToggle.addEventListener('click', messagesAreaResize);

    function messagesAreaResize() {
      width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;
      container.attr("width", width + margin.left + margin.right);
      svg.attr("width", width + margin.left + margin.right);
      x.range([0, width]);
      svg.selectAll('.d3-area').datum( data ).attr("d", area);
    }
  }
};

var _CreateLineChart = function(element, dataset, chartHeight, lineColor, pathColor, pointerLineColor, pointerBgColor) {
	if(element) {
	  var d3Container = d3.select(element),
	      margin = {top: 0, right: 0, bottom: 0, left: 0},
	      width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
	      height = chartHeight - margin.top - margin.bottom,
	      padding = 20;

	  // Format date
	  var parseDate = d3.time.format('%Y-%m-%d').parse,
	      formatDate = d3.time.format("%a, %B %e");

	  var tooltip = d3.tip()
	      .attr('class', 'd3-tip')
	      .html(function (d) {
	          return "<ul class='list-unstyled mb-1'>" +
	              "<li>" + "<div class='font-size-base my-1'><i class='icon-check2 mr-2'></i>" + formatDate(d.date) + "</div>" + "</li>" +
	              "<li>" + d.value + " Properties" + "</li>" +
	          "</ul>";
	      });

	  var container = d3Container.append('svg');
	  var svg = container.attr('width', width + margin.left + margin.right).attr('height', height + margin.top + margin.bottom).append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")").call(tooltip);

	  dataset.forEach(function (d) {
	      d.date = parseDate(d.date);
	      d.value = +d.value;
	  });

	  var x = d3.time.scale().range([padding, width - padding]);
	  var y = d3.scale.linear().range([height, 5]);
	  x.domain(d3.extent(dataset, function (d) { return d.date; }));
	  y.domain([0, d3.max(dataset, function (d) { return Math.max(d.value); })]);
	  var line = d3.svg.line().x(function(d) { return x(d.date); }).y(function(d) { return y(d.value); });

	  var clip = svg.append("defs").append("clipPath").attr("id", "clip-line-small");
	  var clipRect = clip.append("rect").attr('class', 'clip').attr("width", 0).attr("height", height);

	  clipRect.transition().duration(1000).ease('linear').attr("width", width);
	  var path = svg.append('path').attr({ 'd': line(dataset), "clip-path": "url(#clip-line-small)", 'class': 'd3-line d3-line-medium' }).style('stroke', lineColor);
	  svg.select('.line-tickets').transition().duration(1000).ease('linear');
	  var guide = svg.append('g').selectAll('.d3-line-guides-group').data(dataset);
	  guide.enter().append('line').attr('class', 'd3-line-guides').attr('x1', function (d, i) { return x(d.date); }).attr('y1', function (d, i) { return height; }).attr('x2', function (d, i) { return x(d.date); }).attr('y2', function (d, i) { return height; }).style('stroke', pathColor).style('stroke-dasharray', '4,2').style('shape-rendering', 'crispEdges');
	  guide.transition().duration(1000).delay(function(d, i) { return i * 150; }).attr('y2', function (d, i) { return y(d.value); });
	  var points = svg.insert('g').selectAll('.d3-line-circle').data(dataset).enter().append('circle').attr('class', 'd3-line-circle d3-line-circle-medium').attr("cx", line.x()).attr("cy", line.y()).attr("r", 3).style({ 'stroke': pointerLineColor, 'fill': pointerBgColor });
	  points.style('opacity', 0).transition().duration(250).ease('linear').delay(1000).style('opacity', 1);
	  points.on("mouseover", function (d) { tooltip.offset([-10, 0]).show(d); d3.select(this).transition().duration(250).attr('r', 4); }).on("mouseout", function (d) { tooltip.hide(d); d3.select(this).transition().duration(250).attr('r', 3); });
	  d3.select(points[0][0]).on("mouseover", function (d) { tooltip.offset([0, 10]).direction('e').show(d); d3.select(this).transition().duration(250).attr('r', 4); }).on("mouseout", function (d) { tooltip.direction('n').hide(d); d3.select(this).transition().duration(250).attr('r', 3); });

	  d3.select(points[0][points.size() - 1]).on("mouseover", function (d) { tooltip.offset([0, -10]).direction('w').show(d); d3.select(this).transition().duration(250).attr('r', 4); }).on("mouseout", function (d) { tooltip.direction('n').hide(d); d3.select(this).transition().duration(250).attr('r', 3); });

	  $(window).on('resize', lineChartResize);
	  $(document).on('click', '.sidebar-control', lineChartResize);
	  function lineChartResize() {
	    width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;
	    container.attr("width", width + margin.left + margin.right);
	    svg.attr("width", width + margin.left + margin.right);
	    x.range([padding, width - padding]);
	    clipRect.attr("width", width);
	    svg.selectAll('.d3-line').attr("d", line(dataset));
	    svg.selectAll('.d3-line-circle').attr("cx", line.x());
	    svg.selectAll('.d3-line-guides').attr('x1', function (d, i) { return x(d.date); }).attr('x2', function (d, i) { return x(d.date); });
	  }
	}
};























var chart_data = [
  {
    "date": "2014-07-01",
    "value": 1203
  },
  {
    "date": "2014-07-02",
    "value": 480
  },
  {
    "date": "2014-07-03",
    "value": 903
  },
  {
    "date": "2014-07-04",
    "value": 790
  },
  {
    "date": "2014-07-05",
    "value": 1423
  },
  {
    "date": "2014-07-06",
    "value": 1222
  },
  {
    "date": "2014-07-07",
    "value": 948
  },
  {
    "date": "2014-07-08",
    "value": 1338
  },
  {
    "date": "2014-07-09",
    "value": 543
  },
  {
    "date": "2014-07-10",
    "value": 940
  },
  {
    "date": "2014-07-11",
    "value": 1245
  },
  {
    "date": "2014-07-12",
    "value": 683
  },
  {
    "date": "2014-07-13",
    "value": 898
  },
  {
    "date": "2014-07-14",
    "value": 1023
  },
  {
    "date": "2014-07-15",
    "value": 857
  },
  {
    "date": "2014-07-16",
    "value": 490
  },
  {
    "date": "2014-07-17",
    "value": 1009
  },
  {
    "date": "2014-07-18",
    "value": 437
  },
  {
    "date": "2014-07-19",
    "value": 735
  },
  {
  "date": "2014-07-20",
  "value": 865
  },
  {
  "date": "2014-07-21",
  "value": 478
  },
  {
  "date": "2014-07-22",
  "value": 690
  },
  {
  "date": "2014-07-23",
  "value": 954
  },
  {
  "date": "2014-07-24",
  "value": 1192
  },
  {
  "date": "2014-07-25",
  "value": 586
  },
  {
  "date": "2014-07-26",
  "value": 893
  },
  {
  "date": "2014-07-27",
  "value": 801
  },
  {
  "date": "2014-07-28",
  "value": 1182
  },
  {
  "date": "2014-07-29",
  "value": 1026
  },
  {
  "date": "2014-07-30",
  "value": 786
  },
  {
  "date": "2014-07-31",
  "value": 1056
  }
];
var line_data = [
    {
        "date": "04/13/14",
        "alpha": "60"
    }, {
        "date": "04/14/14",
        "alpha": "35"
    }, {
        "date": "04/15/14",
        "alpha": "65"
    }, {
        "date": "04/16/14",
        "alpha": "50"
    }, {
        "date": "04/17/14",
        "alpha": "65"
    }, {
        "date": "04/18/14",
        "alpha": "20"
    }, {
        "date": "04/19/14",
        "alpha": "60"
    }
];
var bardata = [];
for (var i=0; i < 24; i++) {
    bardata.push(Math.round(Math.random() * 10) + 10);
}
jQuery(document).ready(function() {

	_CreateAreaChart("#first_chart", cortiamajax.invoice_chart, 50, '#5C6BC0');
	_CreateBarChart("#second_chart", cortiamajax.agent_chart, 24, 50, true, "elastic", 1200, 50, "#EF5350", "members");
	_CreateBarChart("#third_chart", cortiamajax.seller_chart,24, 50, true, "elastic", 1200, 50, "#EF5350", "members");
  _CreateLineChart('#fourth_chart', cortiamajax.properties_chart, 50, '#2196F3', 'rgba(33,150,243,0.5)', '#2196F3', '#2196F3');
});

