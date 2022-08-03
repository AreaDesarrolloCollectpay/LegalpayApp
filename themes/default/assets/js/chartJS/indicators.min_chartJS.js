$(function () {
    $('#m-indicators').addClass('active');
    

    // For example:
    var myLineChart;
    var labels = [];
    var dataC = [];
    var colors = [];
    var config = [];
    getChart(0);
    
    function getChart(state){
        console.log('chart');
        var formElement = document.querySelector(".form-filter-indicators");
        var form = new FormData(formElement);  
        
        $.ajax({
            url: SITEURL + "/indicators/getChart",
            async: false,
            dataType: 'json',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function (result) {
                //if (result.status == "success") {
                    labels = result.labels;              
                    dataC = result.datac;              
                    colors = result.colors;              
                //}
            }
        });
                
        config = {
        type: 'pie',
        data: {
            datasets: [{
                    label: '',
                    backgroundColor: colors,
                    data: dataC,
                }],
            labels: labels,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'ESTADOS CARTERA',
                position: 'right',
                fontStyle: 'normal'
            },
            'onClick' : function(event, array) {
                let element = this.getElementAtEvent(event);
                if (element.length > 0) {
                    var label = element[0]._model.label;
                    var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                    modalWallet(label,value);
                }
            },            
            legend: {
                display: true,
                position : 'left',
                fullWidth: true,
                labels: {
                    fontSize: 12,
                    boxWidth : 10,
                    padding : 18,
                }
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return "$" + Number(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]).toFixed(0).replace(/./g, function (c, i, a) {
                            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                        });
                    }
                }
            }
        }
    };
            
    var ctx = document.getElementById('canvas').getContext('2d');
    ctx.canvas.height = 300;
    if(state == 1){
        myLineChart.destroy();
    }
    myLineChart = new Chart(ctx, config);        
        
    }
    
    $('body').on('change', '.form-indicators', function (e) {
        e.preventDefault();
        getChart(1);
    });
    
    
    function modalWallet(label,value){
        
        var formElement = document.querySelector(".form-filter-indicators");
        var form = new FormData(formElement); 
        form.append("state", label);
        $.ajax({
            url: SITEURL + "/indicators/getDebtors",
            async: false,
            dataType: 'json',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.status == "success") {
                    $("#content-modal-indicators").html(result.html);
                    pagination();
                    setTimeout(function(){
                        $("#debtors_indicators_modal").openModal();                         
                    },800);
                }
            }
        });
        
    }
    function pagination(){  
        $('body').on('click','ul.pagination > li > a', function (e) {
            e.preventDefault();
            var _this = $(this);
            
            $.ajax({
                url: _this.attr('href'),
                async: false,
                dataType: 'json',
                type: 'POST',
                data: {},
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.status == "success") {
                        $("#content-modal-indicators").html(result.html);
                        pagination();
                    }
                }
            });

        });
    }
    
//    document.getElementById("canvas").style.height = '128px';
//    document.getElementById("canvas-2").style.height = '128px';
    
});


