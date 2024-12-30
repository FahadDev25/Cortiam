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
			url: cortiamajax.propertydataurl,
		  data: {'startdate' : jQuery('#start_date').val(), 'enddate' : jQuery('#end_date').val()},
			dataType: "json",
			beforeSend: function() {
				jQuery('.content').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
			},
			success: function(response){
				if(response.success){
					jQuery('#numbercommercial').html(response.reportdata.numbers.commercial);
					jQuery('#numberresidential').html(response.reportdata.numbers.residential);
					jQuery('#numberactivated').html(response.reportdata.numbers.pending);
					jQuery('#numberpending').html(response.reportdata.numbers.declined);
					jQuery('#numberdeclined').html(response.reportdata.numbers.active);
					jQuery('#numbercontracted').html(response.reportdata.numbers.contracted);
					jQuery('#numberinactivated').html(response.reportdata.numbers.inactive);
					prop_zoom.setOption({
				    xAxis: [{
				        data: response.reportdata.formatted.dates
				    }],
				    series: [
				        {type: 'line',data: response.reportdata.formatted.commercial},
				        {type: 'line',data: response.reportdata.formatted.residential},
				        {type: 'line',data: response.reportdata.formatted.pending},
				        {type: 'line',data: response.reportdata.formatted.declined},
				        {type: 'line',data: response.reportdata.formatted.active},
				        {type: 'line',data: response.reportdata.formatted.contracted},
				        {type: 'line',data: response.reportdata.formatted.inactive}
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
						  { "type": "string", "targets": 1, "data": "commercial", "title": "Commercial"},
						  { "type": "string", "targets": 2, "data": "residential", "title": "Residential"},
						  { "type": "string", "targets": 3, "data": "actives", "title": "Activated"},
						  { "type": "string", "targets": 4, "data": "pending", "title": "Pending"},
						  { "type": "string", "targets": 5, "data": "declined", "title": "Declined"},
						  { "type": "string", "targets": 6, "data": "contracted", "title": "Contracted"},
						  { "type": "string", "targets": 7, "data": "inactive", "title": "Inactivated"},
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
			  { "type": "string", "targets": 1, "data": "commercial", "title": "Commercial"},
			  { "type": "string", "targets": 2, "data": "residential", "title": "Residential"},
			  { "type": "string", "targets": 3, "data": "actives", "title": "Activated"},
			  { "type": "string", "targets": 4, "data": "pending", "title": "Pending"},
			  { "type": "string", "targets": 5, "data": "declined", "title": "Declined"},
			  { "type": "string", "targets": 6, "data": "contracted", "title": "Contracted"},
			  { "type": "string", "targets": 7, "data": "inactive", "title": "Inactivated"},
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

var prop_zoom_element = document.getElementById('prop_chart');
prop_zoom = echarts.init(prop_zoom_element);
prop_zoom.setOption({
    color: ["#00a1ea", "#4ea32a", '#df79a7', "#30408d", '#cb2c1a', "#aeda00", '#37d1ff'],
    textStyle: {
        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
        fontSize: 13
    },
    animationDuration: 750,
    grid: {
        left: 0,
        right: 40,
        top: 35,
        bottom: 60,
        containLabel: true
    },
    legend: {
        data: ['Commercial Properties', 'Residential Properties', 'Pending', 'Decliend', 'Active', 'Contracted', 'Inactivated'],
        itemHeight: 4,
        itemGap: 10
    },
    tooltip: {
        trigger: 'axis',
        backgroundColor: 'rgba(0,0,0,0.75)',
        padding: [10, 15],
        textStyle: {
            fontSize: 13,
            fontFamily: 'Roboto, sans-serif'
        }
    },
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
    series: [
        {
            name: 'Commercial Properties',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.commercial
        },
        {
            name: 'Residential Properties',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.residential
        },
        {
            name: 'Pending',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.pending
        },
        {
            name: 'Declined',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.declined
        },
        {
            name: 'Active',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.active
        },
        {
            name: 'Contracted',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.contracted
        },
        {
            name: 'Inactivated',
            type: 'line',
            smooth: true,
            symbolSize: 6,
            itemStyle: {
                normal: {
                    borderWidth: 2
                }
            },
            data: cortiamajax.reportdata.inactive
        }
    ]
});
// Resize function
var triggerChartResize = function() {
    prop_zoom_element && prop_zoom.resize();
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