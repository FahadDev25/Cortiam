jQuery(document).ready(function() {

  jQuery('#reportrange').daterangepicker({
      applyClass: 'btn-primary',
      cancelClass: 'btn-light',
      ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          'This Year': [moment().startOf('year'), moment().endOf('year')],
      },
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month'),
      opens: 'left',
  }, function (start, end) {
		jQuery('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		jQuery('#start_date').val(start.format('MMMM D, YYYY'));
		jQuery('#end_date').val(end.format('MMMM D, YYYY'));
  });


	jQuery('#reportrange').on('apply.daterangepicker', function(ev, picker) {

		jQuery.ajax({
			type: "post",
			url: cortiamajax.userdataurl,
		  data: {'startdate' : jQuery('#start_date').val(), 'enddate' : jQuery('#end_date').val()},
			dataType: "json",
			beforeSend: function() {
				jQuery('.content').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
			},
			success: function(response){
				if(response.success){
					jQuery('#numberseller').html(response.reportdata.numbers.seller);
					jQuery('#numberagent').html(response.reportdata.numbers.agent);
					jQuery('#numberapproveds').html(response.reportdata.numbers.approveds);
					jQuery('#numberwaitings').html(response.reportdata.numbers.waitings);
					jQuery('#numberdenieds').html(response.reportdata.numbers.denieds);
					user_zoom.setOption({
				    xAxis: [{
				        data: response.reportdata.formatted.dates
				    }],
					  series: [
					      {data: response.reportdata.formatted.seller},
					      {data: response.reportdata.formatted.agent},
					      {data: response.reportdata.formatted.approveds},
					      {data: response.reportdata.formatted.waitings},
					      {data: response.reportdata.formatted.denieds}
					  ]
					});
				}else{
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
				}
				jQuery('.content').unblock();
				ourdatatable.destroy();
			  ourdatatable = jQuery('#reporttable').DataTable({
			      dom: '<"datatable-buttons"B><"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
			      "responsive": true,
			      "autoWidth": false,
			      "bAutoWidth": false,
			      "colReorder": true,
			      "order": [[ 0, "asc" ]],
			      "paging": true,
			      "pageLength": 25,
			      "lengthMenu": [ 10, 25, 50, 75, 100 ],
				    "rowId":function(a) {
					    return 'record-' + a.record_id;
					  },
					  "data": response.reportdata.datatable,
						"columnDefs": [
						  { "type": "string", "targets": 0, "data": "date", "title": "Date", "width": "160px"},
						  { "type": "string", "targets": 1, "data": "seller", "title": "Seller Accounts"},
						  { "type": "string", "targets": 2, "data": "agent", "title": "Agent Accounts"},
						  { "type": "string", "targets": 3, "data": "approveds", "title": "Approved Accounts"},
						  { "type": "string", "targets": 4, "data": "waitings", "title": "Waiting Approval"},
						  { "type": "string", "targets": 5, "data": "denieds", "title": "Denied Accounts"},
						],
			      buttons: {
			          buttons: [
			              {
			                  extend: 'copyHtml5',
			                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
			                  exportOptions: {
			                      columns: [ 0, ':visible' ]
			                  }
			              },
			                {
			                    extend: 'print',
			                    text: ' Print',
			                    className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
			                  	exportOptions: {
			                      columns: ':visible'
			                  	}
			                },
			              {
			                  extend: 'excelHtml5',
			                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
			                  exportOptions: {
			                      columns: ':visible'
			                  }
			              },
			              {
			                  extend: 'pdfHtml5',
			                  orientation: 'landscape',
											  customize: function (doc) {
											    doc.content[1].table.widths =
											        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
											  },
			                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
			                  exportOptions: {
			                      columns: ':visible'
			                  }
			              },
			              {
			                  extend: 'colvis',
			                  text: '<i class="icon-three-bars"></i>',
			                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate btn-icon dropdown-toggle'
			              }
			          ]
			      }
			  });
			}
		});
	});

  ourdatatable = jQuery('#reporttable').DataTable({
      dom: '<"datatable-buttons"B><"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 0, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
	    "rowId":function(a) {
		    return 'record-' + a.record_id;
		  },
		  "data": cortiamajax.tabledata,
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "date", "title": "Date", "width": "160px"},
			  { "type": "string", "targets": 1, "data": "seller", "title": "Seller Accounts"},
			  { "type": "string", "targets": 2, "data": "agent", "title": "Agent Accounts"},
			  { "type": "string", "targets": 3, "data": "approveds", "title": "Approved Accounts"},
			  { "type": "string", "targets": 4, "data": "waitings", "title": "Waiting Approval"},
			  { "type": "string", "targets": 5, "data": "denieds", "title": "Denied Accounts"},
			],
      buttons: {
          buttons: [
              {
                  extend: 'copyHtml5',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: [ 0, ':visible' ]
                  }
              },
                {
                    extend: 'print',
                    text: ' Print',
                    className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  	exportOptions: {
                      columns: ':visible'
                  	}
                },
              {
                  extend: 'excelHtml5',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
              {
                  extend: 'pdfHtml5',
                  orientation: 'landscape',
								  customize: function (doc) {
								    doc.content[1].table.widths =
								        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
								  },
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
              {
                  extend: 'colvis',
                  text: '<i class="icon-three-bars"></i>',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate btn-icon dropdown-toggle'
              }
          ]
      }
  });

});

var user_zoom_element = document.getElementById('user_chart');


// Initialize chart
user_zoom = echarts.init(user_zoom_element);


//
// Chart config
//

// Options
user_zoom.setOption({

    // Define colors
    color: ["#00a1ea", "#4ea32a", '#df79a7', "#30408d", '#cb2c1a'],

    // Global text styles
    textStyle: {
        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
        fontSize: 13
    },

    // Chart animation duration
    animationDuration: 750,

    // Setup grid
    grid: {
        left: 0,
        right: 40,
        top: 35,
        bottom: 60,
        containLabel: true
    },

    // Add legend
    legend: {
        data: ['Sellers', 'Agents', 'Approved Accounts', 'Approval Waiting', 'Denied Accounts'],
        itemHeight: 4,
        itemGap: 10
    },

    // Add tooltip
    tooltip: {
        trigger: 'axis',
        backgroundColor: 'rgba(0,0,0,0.75)',
        padding: [10, 15],
        textStyle: {
            fontSize: 13,
            fontFamily: 'Roboto, sans-serif'
        }
    },

    // Horizontal axis
    xAxis: [{
        type: 'category',
        boundaryGap: false,
        axisLabel: {
            color: '#333'
        },
        axisLine: {
            lineStyle: {
                color: '#999'
            }
        },
        data: cortiamajax.reportdata.dates
    }],

    // Vertical axis
    yAxis: [{
        type: 'value',
        axisLabel: {
            formatter: '{value} ',
            color: '#333'
        },
        axisLine: {
            lineStyle: {
                color: '#999'
            }
        },
        splitLine: {
            lineStyle: {
                color: ['#eee']
            }
        },
        splitArea: {
            show: true,
            areaStyle: {
                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
            }
        }
    }],

    // Zoom control
    dataZoom: [
        {
            type: 'inside',
            start: 0,
            end: 100
        },
        {
            show: true,
            type: 'slider',
            start: 0,
            end: 100,
            height: 40,
            bottom: 0,
            borderColor: '#ccc',
            fillerColor: 'rgba(0,0,0,0.05)',
            handleStyle: {
                color: '#585f63'
            }
        }
    ],

    // Add series
    series: [
        {
            name: 'Sellers',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.seller
        },
        {
            name: 'Agents',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.agent
        },
        {
            name: 'Approved Accounts',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.approveds
        },
        {
            name: 'Approval Waiting',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.waitings
        },
        {
            name: 'Denied Accounts',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.denieds
        }
    ]
});

// Resize function
var triggerChartResize = function() {
    user_zoom_element && user_zoom.resize();
};

// On sidebar width change
var sidebarToggle = document.querySelector('.sidebar-control');
sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

// On window resize
var resizeCharts;
window.addEventListener('resize', function() {
    clearTimeout(resizeCharts);
    resizeCharts = setTimeout(function () {
        triggerChartResize();
    }, 200);
});