(function(d){function q(){this.regional=[];this.regional[""]={currentText:"Now",closeText:"Done",ampm:!1,amNames:["AM","A"],pmNames:["PM","P"],timeFormat:"hh:mm tt",timeSuffix:"",timeOnlyTitle:"Choose Time",timeText:"Time",hourText:"Hour",minuteText:"Minute",secondText:"Second",millisecText:"Millisecond",timezoneText:"Time Zone"};this._defaults={showButtonPanel:!0,timeOnly:!1,showHour:!0,showMinute:!0,showSecond:!1,showMillisec:!1,showTimezone:!1,showTime:!0,stepHour:1,stepMinute:1,stepSecond:1,stepMillisec:1,
hour:0,minute:0,second:0,millisec:0,timezone:null,useLocalTimezone:!1,defaultTimezone:"+0000",hourMin:0,minuteMin:0,secondMin:0,millisecMin:0,hourMax:23,minuteMax:59,secondMax:59,millisecMax:999,minDateTime:null,maxDateTime:null,onSelect:null,hourGrid:0,minuteGrid:0,secondGrid:0,millisecGrid:0,alwaysSetTime:!0,separator:" ",altFieldTimeOnly:!0,altSeparator:null,altTimeSuffix:null,showTimepicker:!0,timezoneIso8601:!1,timezoneList:null,addSliderAccess:!1,sliderAccessArgs:null,defaultValue:null};d.extend(this._defaults,
this.regional[""])}function r(b,c){d.extend(b,c);for(var a in c)if(null===c[a]||void 0===c[a])b[a]=c[a];return b}d.ui.timepicker=d.ui.timepicker||{};if(!d.ui.timepicker.version){d.extend(d.ui,{timepicker:{version:"1.0.4"}});d.extend(q.prototype,{$input:null,$altInput:null,$timeObj:null,inst:null,hour_slider:null,minute_slider:null,second_slider:null,millisec_slider:null,timezone_select:null,hour:0,minute:0,second:0,millisec:0,timezone:null,defaultTimezone:"+0000",hourMinOriginal:null,minuteMinOriginal:null,
secondMinOriginal:null,millisecMinOriginal:null,hourMaxOriginal:null,minuteMaxOriginal:null,secondMaxOriginal:null,millisecMaxOriginal:null,ampm:"",formattedDate:"",formattedTime:"",formattedDateTime:"",timezoneList:null,units:["hour","minute","second","millisec"],setDefaults:function(b){r(this._defaults,b||{});return this},_newInst:function(b,c){var a=new q,e={},f;for(f in this._defaults)if(this._defaults.hasOwnProperty(f)){var g=b.attr("time:"+f);if(g)try{e[f]=eval(g)}catch(i){e[f]=g}}a._defaults=
d.extend({},this._defaults,e,c,{beforeShow:function(b,e){if(d.isFunction(c.beforeShow))return c.beforeShow(b,e,a)},onChangeMonthYear:function(e,f,g){a._updateDateTime(g);d.isFunction(c.onChangeMonthYear)&&c.onChangeMonthYear.call(b[0],e,f,g,a)},onClose:function(e,f){!0===a.timeDefined&&""!==b.val()&&a._updateDateTime(f);d.isFunction(c.onClose)&&c.onClose.call(b[0],e,f,a)},timepicker:a});a.amNames=d.map(a._defaults.amNames,function(a){return a.toUpperCase()});a.pmNames=d.map(a._defaults.pmNames,function(a){return a.toUpperCase()});
null===a._defaults.timezoneList&&(e="-1200 -1100 -1000 -0930 -0900 -0800 -0700 -0600 -0500 -0430 -0400 -0330 -0300 -0200 -0100 +0000 +0100 +0200 +0300 +0330 +0400 +0430 +0500 +0530 +0545 +0600 +0630 +0700 +0800 +0845 +0900 +0930 +1000 +1030 +1100 +1130 +1200 +1245 +1300 +1400".split(" "),a._defaults.timezoneIso8601&&(e=d.map(e,function(a){return"+0000"==a?"Z":a.substring(0,3)+":"+a.substring(3)})),a._defaults.timezoneList=e);a.timezone=a._defaults.timezone;a.hour=a._defaults.hour;a.minute=a._defaults.minute;
a.second=a._defaults.second;a.millisec=a._defaults.millisec;a.ampm="";a.$input=b;c.altField&&(a.$altInput=d(c.altField).css({cursor:"pointer"}).focus(function(){b.trigger("focus")}));if(0===a._defaults.minDate||0===a._defaults.minDateTime)a._defaults.minDate=new Date;if(0===a._defaults.maxDate||0===a._defaults.maxDateTime)a._defaults.maxDate=new Date;void 0!==a._defaults.minDate&&a._defaults.minDate instanceof Date&&(a._defaults.minDateTime=new Date(a._defaults.minDate.getTime()));void 0!==a._defaults.minDateTime&&
a._defaults.minDateTime instanceof Date&&(a._defaults.minDate=new Date(a._defaults.minDateTime.getTime()));void 0!==a._defaults.maxDate&&a._defaults.maxDate instanceof Date&&(a._defaults.maxDateTime=new Date(a._defaults.maxDate.getTime()));void 0!==a._defaults.maxDateTime&&a._defaults.maxDateTime instanceof Date&&(a._defaults.maxDate=new Date(a._defaults.maxDateTime.getTime()));a.$input.bind("focus",function(){a._onFocus()});return a},_addTimePicker:function(b){var c=this.$altInput&&this._defaults.altFieldTimeOnly?
this.$input.val()+" "+this.$altInput.val():this.$input.val();this.timeDefined=this._parseTime(c);this._limitMinMaxDateTime(b,!1);this._injectTimePicker()},_parseTime:function(b,c){this.inst||(this.inst=d.datepicker._getInst(this.$input[0]));if(c||!this._defaults.timeOnly){var a=d.datepicker._get(this.inst,"dateFormat");try{var e=s(a,this._defaults.timeFormat,b,d.datepicker._getFormatConfig(this.inst),this._defaults);if(!e.timeObj)return!1;d.extend(this,e.timeObj)}catch(f){return!1}}else{a=d.datepicker.parseTime(this._defaults.timeFormat,
b,this._defaults);if(!a)return!1;d.extend(this,a)}return!0},_injectTimePicker:function(){var b=this.inst.dpDiv,c=this.inst.settings,a=this,e="",f="",g={},i={},h=null;if(0===b.find("div.ui-timepicker-div").length&&c.showTimepicker){for(var h='<div class="ui-timepicker-div"><dl><dt class="ui_tpicker_time_label"'+(c.showTime?"":' style="display:none;"')+">"+c.timeText+'</dt><dd class="ui_tpicker_time"'+(c.showTime?"":' style="display:none;"')+"></dd>",l=0,m=this.units.length;l<m;l++){e=this.units[l];
f=e.substr(0,1).toUpperCase()+e.substr(1);g[e]=parseInt(c[e+"Max"]-(c[e+"Max"]-c[e+"Min"])%c["step"+f],10);i[e]=0;h+='<dt class="ui_tpicker_'+e+'_label"'+(c["show"+f]?"":' style="display:none;"')+">"+c[e+"Text"]+'</dt><dd class="ui_tpicker_'+e+'"><div class="ui_tpicker_'+e+'_slider"'+(c["show"+f]?"":' style="display:none;"')+"></div>";if(c["show"+f]&&0<c[e+"Grid"]){h+='<div style="padding-left: 1px"><table class="ui-tpicker-grid-label"><tr>';if("hour"==e)for(f=c[e+"Min"];f<=g[e];f+=parseInt(c[e+"Grid"],
10)){i[e]++;var k=c.ampm&&12<f?f-12:f;10>k&&(k="0"+k);c.ampm&&(k=0===f?"12a":12>f?k+"a":k+"p");h+='<td data-for="'+e+'">'+k+"</td>"}else for(f=c[e+"Min"];f<=g[e];f+=parseInt(c[e+"Grid"],10))i[e]++,h+='<td data-for="'+e+'">'+(10>f?"0":"")+f+"</td>";h+="</tr></table></div>"}h+="</dd>"}var h=h+('<dt class="ui_tpicker_timezone_label"'+(c.showTimezone?"":' style="display:none;"')+">"+c.timezoneText+"</dt>"),h=h+('<dd class="ui_tpicker_timezone" '+(c.showTimezone?"":' style="display:none;"')+"></dd>"),
j=d(h+"</dl></div>");!0===c.timeOnly&&(j.prepend('<div class="ui-widget-header ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-title">'+c.timeOnlyTitle+"</div></div>"),b.find(".ui-datepicker-header, .ui-datepicker-calendar").hide());this.hour_slider=j.find(".ui_tpicker_hour_slider").prop("slide",null).slider({orientation:"horizontal",value:this.hour,min:c.hourMin,max:g.hour,step:c.stepHour,slide:function(c,b){a.hour_slider.slider("option","value",b.value);a._onTimeChange()},stop:function(){a._onSelectHandler()}});
this.minute_slider=j.find(".ui_tpicker_minute_slider").prop("slide",null).slider({orientation:"horizontal",value:this.minute,min:c.minuteMin,max:g.minute,step:c.stepMinute,slide:function(c,b){a.minute_slider.slider("option","value",b.value);a._onTimeChange()},stop:function(){a._onSelectHandler()}});this.second_slider=j.find(".ui_tpicker_second_slider").prop("slide",null).slider({orientation:"horizontal",value:this.second,min:c.secondMin,max:g.second,step:c.stepSecond,slide:function(c,b){a.second_slider.slider("option",
"value",b.value);a._onTimeChange()},stop:function(){a._onSelectHandler()}});this.millisec_slider=j.find(".ui_tpicker_millisec_slider").prop("slide",null).slider({orientation:"horizontal",value:this.millisec,min:c.millisecMin,max:g.millisec,step:c.stepMillisec,slide:function(c,b){a.millisec_slider.slider("option","value",b.value);a._onTimeChange()},stop:function(){a._onSelectHandler()}});l=0;for(m=a.units.length;l<m;l++)e=a.units[l],f=e.substr(0,1).toUpperCase()+e.substr(1),c["show"+f]&&0<c[e+"Grid"]&&
(h=100*i[e]*c[e+"Grid"]/(g[e]-c[e+"Min"]),j.find(".ui_tpicker_"+e+" table").css({width:h+"%",marginLeft:h/(-2*i[e])+"%",borderCollapse:"collapse"}).find("td").click(function(){var b=d(this),e=b.html(),b=b.data("for");if("hour"==b&&c.ampm)var f=e.substring(2).toLowerCase(),e=parseInt(e.substring(0,2),10),e="a"==f?12==e?0:e:12==e?12:e+12;a[b+"_slider"].slider("option","value",parseInt(e,10));a._onTimeChange();a._onSelectHandler()}).css({cursor:"pointer",width:100/i[e]+"%",textAlign:"center",overflow:"hidden"}));
this.timezone_select=j.find(".ui_tpicker_timezone").append("<select></select>").find("select");d.fn.append.apply(this.timezone_select,d.map(c.timezoneList,function(a){return d("<option />").val("object"==typeof a?a.value:a).text("object"==typeof a?a.label:a)}));"undefined"!=typeof this.timezone&&null!==this.timezone&&""!==this.timezone?d.timepicker.timeZoneOffsetString(new Date(this.inst.selectedYear,this.inst.selectedMonth,this.inst.selectedDay,12))==this.timezone?n(a):this.timezone_select.val(this.timezone):
"undefined"!=typeof this.hour&&null!==this.hour&&""!==this.hour?this.timezone_select.val(c.defaultTimezone):n(a);this.timezone_select.change(function(){a._defaults.useLocalTimezone=!1;a._onTimeChange()});e=b.find(".ui-datepicker-buttonpane");e.length?e.before(j):b.append(j);this.$timeObj=j.find(".ui_tpicker_time");null!==this.inst&&(b=this.timeDefined,this._onTimeChange(),this.timeDefined=b);if(this._defaults.addSliderAccess){var t=this._defaults.sliderAccessArgs;setTimeout(function(){if(0===j.find(".ui-slider-access").length){j.find(".ui-slider:visible").sliderAccess(t);
var a=j.find(".ui-slider-access:eq(0)").outerWidth(!0);a&&j.find("table:visible").each(function(){var b=d(this),c=b.outerWidth(),e=b.css("marginLeft").toString().replace("%",""),f=c-a;b.css({width:f,marginLeft:e*f/c+"%"})})}},10)}}},_limitMinMaxDateTime:function(b,c){var a=this._defaults,e=new Date(b.selectedYear,b.selectedMonth,b.selectedDay);if(this._defaults.showTimepicker){if(null!==d.datepicker._get(b,"minDateTime")&&void 0!==d.datepicker._get(b,"minDateTime")&&e){var f=d.datepicker._get(b,"minDateTime"),
g=new Date(f.getFullYear(),f.getMonth(),f.getDate(),0,0,0,0);if(null===this.hourMinOriginal||null===this.minuteMinOriginal||null===this.secondMinOriginal||null===this.millisecMinOriginal)this.hourMinOriginal=a.hourMin,this.minuteMinOriginal=a.minuteMin,this.secondMinOriginal=a.secondMin,this.millisecMinOriginal=a.millisecMin;b.settings.timeOnly||g.getTime()==e.getTime()?(this._defaults.hourMin=f.getHours(),this.hour<=this._defaults.hourMin?(this.hour=this._defaults.hourMin,this._defaults.minuteMin=
f.getMinutes(),this.minute<=this._defaults.minuteMin?(this.minute=this._defaults.minuteMin,this._defaults.secondMin=f.getSeconds(),this.second<=this._defaults.secondMin?(this.second=this._defaults.secondMin,this._defaults.millisecMin=f.getMilliseconds()):(this.millisec<this._defaults.millisecMin&&(this.millisec=this._defaults.millisecMin),this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.minuteMin=
this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.hourMin=this.hourMinOriginal,this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)}if(null!==d.datepicker._get(b,"maxDateTime")&&void 0!==d.datepicker._get(b,"maxDateTime")&&e){f=d.datepicker._get(b,"maxDateTime");g=new Date(f.getFullYear(),f.getMonth(),f.getDate(),
0,0,0,0);if(null===this.hourMaxOriginal||null===this.minuteMaxOriginal||null===this.secondMaxOriginal)this.hourMaxOriginal=a.hourMax,this.minuteMaxOriginal=a.minuteMax,this.secondMaxOriginal=a.secondMax,this.millisecMaxOriginal=a.millisecMax;b.settings.timeOnly||g.getTime()==e.getTime()?(this._defaults.hourMax=f.getHours(),this.hour>=this._defaults.hourMax?(this.hour=this._defaults.hourMax,this._defaults.minuteMax=f.getMinutes(),this.minute>=this._defaults.minuteMax?(this.minute=this._defaults.minuteMax,
this._defaults.secondMax=f.getSeconds()):this.second>=this._defaults.secondMax?(this.second=this._defaults.secondMax,this._defaults.millisecMax=f.getMilliseconds()):(this.millisec>this._defaults.millisecMax&&(this.millisec=this._defaults.millisecMax),this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.hourMax=this.hourMaxOriginal,
this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)}void 0!==c&&!0===c&&(a=parseInt(this._defaults.hourMax-(this._defaults.hourMax-this._defaults.hourMin)%this._defaults.stepHour,10),e=parseInt(this._defaults.minuteMax-(this._defaults.minuteMax-this._defaults.minuteMin)%this._defaults.stepMinute,10),f=parseInt(this._defaults.secondMax-(this._defaults.secondMax-this._defaults.secondMin)%this._defaults.stepSecond,
10),g=parseInt(this._defaults.millisecMax-(this._defaults.millisecMax-this._defaults.millisecMin)%this._defaults.stepMillisec,10),this.hour_slider&&this.hour_slider.slider("option",{min:this._defaults.hourMin,max:a}).slider("value",this.hour),this.minute_slider&&this.minute_slider.slider("option",{min:this._defaults.minuteMin,max:e}).slider("value",this.minute),this.second_slider&&this.second_slider.slider("option",{min:this._defaults.secondMin,max:f}).slider("value",this.second),this.millisec_slider&&
this.millisec_slider.slider("option",{min:this._defaults.millisecMin,max:g}).slider("value",this.millisec))}},_onTimeChange:function(){var b=this.hour_slider?this.hour_slider.slider("value"):!1,c=this.minute_slider?this.minute_slider.slider("value"):!1,a=this.second_slider?this.second_slider.slider("value"):!1,e=this.millisec_slider?this.millisec_slider.slider("value"):!1,f=this.timezone_select?this.timezone_select.val():!1,g=this._defaults;"object"==typeof b&&(b=!1);"object"==typeof c&&(c=!1);"object"==
typeof a&&(a=!1);"object"==typeof e&&(e=!1);"object"==typeof f&&(f=!1);!1!==b&&(b=parseInt(b,10));!1!==c&&(c=parseInt(c,10));!1!==a&&(a=parseInt(a,10));!1!==e&&(e=parseInt(e,10));var i=g[12>b?"amNames":"pmNames"][0],h=b!=this.hour||c!=this.minute||a!=this.second||e!=this.millisec||0<this.ampm.length&&12>b!=(-1!==d.inArray(this.ampm.toUpperCase(),this.amNames))||null===this.timezone&&f!=this.defaultTimezone||null!==this.timezone&&f!=this.timezone;h&&(!1!==b&&(this.hour=b),!1!==c&&(this.minute=c),!1!==
a&&(this.second=a),!1!==e&&(this.millisec=e),!1!==f&&(this.timezone=f),this.inst||(this.inst=d.datepicker._getInst(this.$input[0])),this._limitMinMaxDateTime(this.inst,!0));g.ampm&&(this.ampm=i);this.formattedTime=d.datepicker.formatTime(this._defaults.timeFormat,this,this._defaults);this.$timeObj&&this.$timeObj.text(this.formattedTime+g.timeSuffix);this.timeDefined=!0;h&&this._updateDateTime()},_onSelectHandler:function(){var b=this._defaults.onSelect||this.inst.settings.onSelect,c=this.$input?this.$input[0]:
null;b&&c&&b.apply(c,[this.formattedDateTime,this])},_formatTime:function(b,c){var b=b||{hour:this.hour,minute:this.minute,second:this.second,millisec:this.millisec,ampm:this.ampm,timezone:this.timezone},a=(c||this._defaults.timeFormat).toString(),a=d.datepicker.formatTime(a,b,this._defaults);if(arguments.length)return a;this.formattedTime=a},_updateDateTime:function(b){var b=this.inst||b,c=d.datepicker._daylightSavingAdjust(new Date(b.selectedYear,b.selectedMonth,b.selectedDay)),a=d.datepicker._get(b,
"dateFormat"),b=d.datepicker._getFormatConfig(b),e=null!==c&&this.timeDefined,a=this.formattedDate=d.datepicker.formatDate(a,null===c?new Date:c,b);if(!0===this._defaults.timeOnly)a=this.formattedTime;else if(!0!==this._defaults.timeOnly&&(this._defaults.alwaysSetTime||e))a+=this._defaults.separator+this.formattedTime+this._defaults.timeSuffix;this.formattedDateTime=a;if(this._defaults.showTimepicker)if(this.$altInput&&!0===this._defaults.altFieldTimeOnly)this.$altInput.val(this.formattedTime),this.$input.val(this.formattedDate);
else if(this.$altInput){this.$input.val(a);var a="",e=this._defaults.altSeparator?this._defaults.altSeparator:this._defaults.separator,f=this._defaults.altTimeSuffix?this._defaults.altTimeSuffix:this._defaults.timeSuffix;(a=this._defaults.altFormat?d.datepicker.formatDate(this._defaults.altFormat,null===c?new Date:c,b):this.formattedDate)&&(a+=e);a=this._defaults.altTimeFormat?a+(d.datepicker.formatTime(this._defaults.altTimeFormat,this,this._defaults)+f):a+(this.formattedTime+f);this.$altInput.val(a)}else this.$input.val(a);
else this.$input.val(this.formattedDate);this.$input.trigger("change")},_onFocus:function(){if(!this.$input.val()&&this._defaults.defaultValue){this.$input.val(this._defaults.defaultValue);var b=d.datepicker._getInst(this.$input.get(0)),c=d.datepicker._get(b,"timepicker");if(c&&c._defaults.timeOnly&&b.input.val()!=b.lastVal)try{d.datepicker._updateDatepicker(b)}catch(a){d.datepicker.log(a)}}}});d.fn.extend({timepicker:function(b){var b=b||{},c=Array.prototype.slice.call(arguments);"object"==typeof b&&
(c[0]=d.extend(b,{timeOnly:!0}));return d(this).each(function(){d.fn.datetimepicker.apply(d(this),c)})},datetimepicker:function(b){var b=b||{},c=arguments;return"string"==typeof b?"getDate"==b?d.fn.datepicker.apply(d(this[0]),c):this.each(function(){var a=d(this);a.datepicker.apply(a,c)}):this.each(function(){var a=d(this);a.datepicker(d.timepicker._newInst(a,b)._defaults)})}});d.datepicker.parseDateTime=function(b,c,a,e,d){b=s(b,c,a,e,d);b.timeObj&&(c=b.timeObj,b.date.setHours(c.hour,c.minute,c.second,
c.millisec));return b.date};d.datepicker.parseTime=function(b,c,a){var a=r(r({},d.timepicker._defaults),a||{}),e="^"+b.toString().replace(/h{1,2}/ig,"(\\d?\\d)").replace(/m{1,2}/ig,"(\\d?\\d)").replace(/s{1,2}/ig,"(\\d?\\d)").replace(/l{1}/ig,"(\\d?\\d?\\d)").replace(/t{1,2}/ig,function(a,b){var c=[];a&&d.merge(c,a);b&&d.merge(c,b);c=d.map(c,function(a){return a.replace(/[.*+?|()\[\]{}\\]/g,"\\$&")});return"("+c.join("|")+")?"}(a.amNames,a.pmNames)).replace(/z{1}/ig,"(z|[-+]\\d\\d:?\\d\\d|\\S+)?").replace(/\s/g,
"\\s?")+a.timeSuffix+"$",f=b.toLowerCase().match(/(h{1,2}|m{1,2}|s{1,2}|l{1}|t{1,2}|z)/g),b={h:-1,m:-1,s:-1,l:-1,t:-1,z:-1};if(f)for(var g=0;g<f.length;g++)-1==b[f[g].toString().charAt(0)]&&(b[f[g].toString().charAt(0)]=g+1);f="";e=c.match(RegExp(e,"i"));c={hour:0,minute:0,second:0,millisec:0};if(e){-1!==b.t&&(void 0===e[b.t]||0===e[b.t].length?(f="",c.ampm=""):(f=-1!==d.inArray(e[b.t].toUpperCase(),a.amNames)?"AM":"PM",c.ampm=a["AM"==f?"amNames":"pmNames"][0]));-1!==b.h&&(c.hour="AM"==f&&"12"==e[b.h]?
0:"PM"==f&&"12"!=e[b.h]?parseInt(e[b.h],10)+12:Number(e[b.h]));-1!==b.m&&(c.minute=Number(e[b.m]));-1!==b.s&&(c.second=Number(e[b.s]));-1!==b.l&&(c.millisec=Number(e[b.l]));if(-1!==b.z&&void 0!==e[b.z]){b=e[b.z].toUpperCase();switch(b.length){case 1:b=a.timezoneIso8601?"Z":"+0000";break;case 5:a.timezoneIso8601&&(b="0000"==b.substring(1)?"Z":b.substring(0,3)+":"+b.substring(3));break;case 6:a.timezoneIso8601?"00:00"==b.substring(1)&&(b="Z"):b="Z"==b||"00:00"==b.substring(1)?"+0000":b.replace(/:/,
"")}c.timezone=b}return c}return!1};d.datepicker.formatTime=function(b,c,a){var a=a||{},a=d.extend({},d.timepicker._defaults,a),c=d.extend({hour:0,minute:0,second:0,millisec:0,timezone:"+0000"},c),e=a.amNames[0],f=parseInt(c.hour,10);a.ampm&&(11<f&&(e=a.pmNames[0],12<f&&(f%=12)),0===f&&(f=12));b=b.replace(/(?:hh?|mm?|ss?|[tT]{1,2}|[lz]|('.*?'|".*?"))/g,function(b){switch(b.toLowerCase()){case "hh":return("0"+f).slice(-2);case "h":return f;case "mm":return("0"+c.minute).slice(-2);case "m":return c.minute;
case "ss":return("0"+c.second).slice(-2);case "s":return c.second;case "l":return("00"+c.millisec).slice(-3);case "z":return null===c.timezone?a.defaultTimezone:c.timezone;case "t":case "tt":return a.ampm?(1==b.length&&(e=e.charAt(0)),"T"===b.charAt(0)?e.toUpperCase():e.toLowerCase()):"";default:return b.replace(/\'/g,"")||"'"}});return b=d.trim(b)};d.datepicker._base_selectDate=d.datepicker._selectDate;d.datepicker._selectDate=function(b,c){var a=this._getInst(d(b)[0]),e=this._get(a,"timepicker");
e?(e._limitMinMaxDateTime(a,!0),a.inline=a.stay_open=!0,this._base_selectDate(b,c),a.inline=a.stay_open=!1,this._notifyChange(a),this._updateDatepicker(a)):this._base_selectDate(b,c)};d.datepicker._base_updateDatepicker=d.datepicker._updateDatepicker;d.datepicker._updateDatepicker=function(b){var c=b.input[0];if(!d.datepicker._curInst||!(d.datepicker._curInst!=b&&d.datepicker._datepickerShowing&&d.datepicker._lastInput!=c))if("boolean"!==typeof b.stay_open||!1===b.stay_open)if(this._base_updateDatepicker(b),
c=this._get(b,"timepicker"))c._addTimePicker(b),c._defaults.useLocalTimezone&&(n(c,new Date(b.selectedYear,b.selectedMonth,b.selectedDay,12)),c._onTimeChange())};d.datepicker._base_doKeyPress=d.datepicker._doKeyPress;d.datepicker._doKeyPress=function(b){var c=d.datepicker._getInst(b.target),a=d.datepicker._get(c,"timepicker");if(a&&d.datepicker._get(c,"constrainInput")){var e=a._defaults.ampm,c=d.datepicker._possibleChars(d.datepicker._get(c,"dateFormat")),a=a._defaults.timeFormat.toString().replace(/[hms]/g,
"").replace(/TT/g,e?"APM":"").replace(/Tt/g,e?"AaPpMm":"").replace(/tT/g,e?"AaPpMm":"").replace(/T/g,e?"AP":"").replace(/tt/g,e?"apm":"").replace(/t/g,e?"ap":"")+" "+a._defaults.separator+a._defaults.timeSuffix+(a._defaults.showTimezone?a._defaults.timezoneList.join(""):"")+a._defaults.amNames.join("")+a._defaults.pmNames.join("")+c,e=String.fromCharCode(void 0===b.charCode?b.keyCode:b.charCode);return b.ctrlKey||" ">e||!c||-1<a.indexOf(e)}return d.datepicker._base_doKeyPress(b)};d.datepicker._base_doKeyUp=
d.datepicker._doKeyUp;d.datepicker._doKeyUp=function(b){var c=d.datepicker._getInst(b.target),a=d.datepicker._get(c,"timepicker");if(a&&a._defaults.timeOnly&&c.input.val()!=c.lastVal)try{d.datepicker._updateDatepicker(c)}catch(e){d.datepicker.log(e)}return d.datepicker._base_doKeyUp(b)};d.datepicker._base_gotoToday=d.datepicker._gotoToday;d.datepicker._gotoToday=function(b){var c=this._getInst(d(b)[0]),a=c.dpDiv;this._base_gotoToday(b);b=this._get(c,"timepicker");n(b);this._setTime(c,new Date);d(".ui-datepicker-today",
a).click()};d.datepicker._disableTimepickerDatepicker=function(b){var c=this._getInst(b);if(c){var a=this._get(c,"timepicker");d(b).datepicker("getDate");a&&(a._defaults.showTimepicker=!1,a._updateDateTime(c))}};d.datepicker._enableTimepickerDatepicker=function(b){var c=this._getInst(b);if(c){var a=this._get(c,"timepicker");d(b).datepicker("getDate");a&&(a._defaults.showTimepicker=!0,a._addTimePicker(c),a._updateDateTime(c))}};d.datepicker._setTime=function(b,c){var a=this._get(b,"timepicker");if(a){var e=
a._defaults;a.hour=c?c.getHours():e.hour;a.minute=c?c.getMinutes():e.minute;a.second=c?c.getSeconds():e.second;a.millisec=c?c.getMilliseconds():e.millisec;a._limitMinMaxDateTime(b,!0);a._onTimeChange();a._updateDateTime(b)}};d.datepicker._setTimeDatepicker=function(b,c,a){if(b=this._getInst(b)){var e=this._get(b,"timepicker");e&&(this._setDateFromField(b),c&&("string"==typeof c?(e._parseTime(c,a),c=new Date,c.setHours(e.hour,e.minute,e.second,e.millisec)):c=new Date(c.getTime()),"Invalid Date"==c.toString()&&
(c=void 0),this._setTime(b,c)))}};d.datepicker._base_setDateDatepicker=d.datepicker._setDateDatepicker;d.datepicker._setDateDatepicker=function(b,c){var a=this._getInst(b);if(a){var e=c instanceof Date?new Date(c.getTime()):c;this._updateDatepicker(a);this._base_setDateDatepicker.apply(this,arguments);this._setTimeDatepicker(b,e,!0)}};d.datepicker._base_getDateDatepicker=d.datepicker._getDateDatepicker;d.datepicker._getDateDatepicker=function(b,c){var a=this._getInst(b);if(a){var e=this._get(a,"timepicker");
return e?(void 0===a.lastVal&&this._setDateFromField(a,c),(a=this._getDate(a))&&e._parseTime(d(b).val(),e.timeOnly)&&a.setHours(e.hour,e.minute,e.second,e.millisec),a):this._base_getDateDatepicker(b,c)}};d.datepicker._base_parseDate=d.datepicker.parseDate;d.datepicker.parseDate=function(b,c,a){var e;try{e=this._base_parseDate(b,c,a)}catch(d){e=this._base_parseDate(b,c.substring(0,c.length-(d.length-d.indexOf(":")-2)),a)}return e};d.datepicker._base_formatDate=d.datepicker._formatDate;d.datepicker._formatDate=
function(b){var c=this._get(b,"timepicker");return c?(c._updateDateTime(b),c.$input.val()):this._base_formatDate(b)};d.datepicker._base_optionDatepicker=d.datepicker._optionDatepicker;d.datepicker._optionDatepicker=function(b,c,a){var e=this._getInst(b);if(!e)return null;if(e=this._get(e,"timepicker")){var d=null,g=null,i=null;"string"==typeof c?"minDate"===c||"minDateTime"===c?d=a:"maxDate"===c||"maxDateTime"===c?g=a:"onSelect"===c&&(i=a):"object"==typeof c&&(c.minDate?d=c.minDate:c.minDateTime?
d=c.minDateTime:c.maxDate?g=c.maxDate:c.maxDateTime&&(g=c.maxDateTime));d?(d=0===d?new Date:new Date(d),e._defaults.minDate=d,e._defaults.minDateTime=d):g?(g=0===g?new Date:new Date(g),e._defaults.maxDate=g,e._defaults.maxDateTime=g):i&&(e._defaults.onSelect=i)}return void 0===a?this._base_optionDatepicker(b,c):this._base_optionDatepicker(b,c,a)};var s=function(b,c,a,e,f){var g;a:{try{var i=f&&f.separator?f.separator:d.timepicker._defaults.separator,h=f&&f.timeFormat?f.timeFormat:d.timepicker._defaults.timeFormat,
l=f&&f.ampm?f.ampm:d.timepicker._defaults.ampm,m=h.split(i),k=m.length,j=a.split(i),n=j.length;l||(m=d.trim(h.replace(/t/gi,"")).split(i),k=m.length);if(1<n){g=[j.splice(0,n-k).join(i),j.splice(0,k).join(i)];break a}}catch(p){if(0<=p.indexOf(":")){g=a.length-(p.length-p.indexOf(":")-2);a.substring(g);g=[d.trim(a.substring(0,g)),d.trim(a.substring(g))];break a}else throw p;}g=[a,""]}b=d.datepicker._base_parseDate(b,g[0],e);if(""!==g[1]){c=d.datepicker.parseTime(c,g[1],f);if(null===c)throw"Wrong time format";
return{date:b,timeObj:c}}return{date:b}},n=function(b,c){if(b&&b.timezone_select){b._defaults.useLocalTimezone=!0;var a=d.timepicker.timeZoneOffsetString("undefined"!==typeof c?c:new Date);b._defaults.timezoneIso8601&&(a=a.substring(0,3)+":"+a.substring(3));b.timezone_select.val(a)}};d.timepicker=new q;d.timepicker.timeZoneOffsetString=function(b){var b=-1*b.getTimezoneOffset(),c=b%60;return(0<=b?"+":"-")+("0"+(101*((b-c)/60)).toString()).substr(-2)+("0"+(101*c).toString()).substr(-2)};d.timepicker.timeRange=
function(b,c,a){return d.timepicker.handleRange("timepicker",b,c,a)};d.timepicker.dateTimeRange=function(b,c,a){d.timepicker.dateRange(b,c,a,"datetimepicker")};d.timepicker.dateRange=function(b,c,a,e){d.timepicker.handleRange(e||"datepicker",b,c,a)};d.timepicker.handleRange=function(b,c,a,e){function f(b,d,e){d.val()&&new Date(c.val())>new Date(a.val())&&d.val(e)}function g(a,c,e){d(a).val()&&(a=d(a)[b].call(d(a),"getDate"),a.getTime&&d(c)[b].call(d(c),"option",e,a))}d.fn[b].call(c,d.extend({onClose:function(b){f(this,
a,b)},onSelect:function(){g(this,a,"minDate")}},e,e.start));d.fn[b].call(a,d.extend({onClose:function(a){f(this,c,a)},onSelect:function(){g(this,c,"maxDate")}},e,e.end));"timepicker"!=b&&e.reformat&&d([c,a]).each(function(){var a=d(this)[b].call(d(this),"option","dateFormat"),c=new Date(d(this).val());d(this).val()&&c&&d(this).val(d.datepicker.formatDate(a,c))});f(c,a,c.val());g(c,a,"minDate");g(a,c,"maxDate");return d([c.get(0),a.get(0)])};d.timepicker.version="1.0.4"}})(jQuery);