function deleteConfirm(url){
	swal({
		title: "Apakah Anda yakin?",
		text: "Setelah dihapus, data tidak dapat dikembalikan.",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			window.location.href = url;
		}
	});
}

function loadDatePicker(element){
	if(element == '.datepicker'){
		comp = {
			calendar: true,
			date: true,
			month: true,
			year: true,
			decades: true,
			clock: false,
			hours: false,
			minutes: false,
			seconds: false,
			useTwentyfourHour: false
		}
		form = 'YYYY-MM-DD'
	}else{
		comp = {
			calendar: true,
			date: true,
			month: true,
			year: true,
			decades: true,
			clock: true,
			hours: true,
			minutes: true,
			seconds: false,
			useTwentyfourHour: true
		}
		form = 'YYYY-MM-DD hh:mm'
	}
	$(element).each(function(){
		let d = new tempusDominus.TempusDominus(this, 
		{
			display: {
				icons: {
					type: 'icons',
					time: 'fa fa-solid fa-clock',
					date: 'fa fa-solid fa-calendar-alt',
					up: 'fa fa-solid fa-arrow-up',
					down: 'fa fa-solid fa-arrow-down',
					previous: 'fa fa-solid fa-chevron-left',
					next: 'fa fa-solid fa-chevron-right',
					today: 'fa fa-solid fa-dot-circle',
					clear: 'fa fa-solid fa-trash',
					close: 'fa fa-solid fa-times'
				},
				sideBySide: false,
				calendarWeeks: false,
				viewMode: 'calendar',
				toolbarPlacement: 'bottom',
				keepOpen: false,
				buttons: {
					today: true,
					clear: false,
					close: false
				},
				components: comp,
				inline: false,
				theme: 'light'
			},
			localization: {
				today: 'Waktu Sekarang',
			}
		
		});
		d.dates.formatInput = function(date) { {return moment(date).format(form) } }
	});
}