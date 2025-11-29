var App = new Vue({
	el: '#app',
	data: {
		time_in_morning: '',
		time_out_morning: '',
		time_in_afternoon: '',
		time_out_afternoon: '',
		original_timein_html: '',
	},
	mounted() {
		var self = this;
		if($('.timein').length){
			self.original_timein_html = $('.timein')[0].outerHTML;
		}
	},
	methods: {
		TimeInMorning: function() {
			var self = this;
			var id = $('#employee-id').val();
			var form = { content: this.time_in_morning };
			var link = '/payroll/admin/vue/TimeInMorning.php';
			$.ajax({
				url: link,
				type: 'post',
				dataType: 'json',
				data: form,
				success: function(data){
					if(data && data.status === 'success'){
						$('.timein').replaceWith('<h4 class="timein text-success">Entrada registrada: ID-'+ id +' </h4>');
						self.time_in_morning = '';
						$('#employee-id').val('');
						$('#employee-id').focus();
						setTimeout(function(){
							$('.timein').replaceWith(self.original_timein_html || '<h4 class="timein">Tiempo de entrada Matutina</h4>');
						}, 2500);
					} else {
						var msg = (data && data.message) ? data.message : 'Error al registrar entrada';
						$('.timein').replaceWith('<h4 class="timein text-danger">'+ msg +'</h4>');
						setTimeout(function(){ $('#employee-id').focus(); }, 1500);
					}
				},
				error: function(xhr){
					console.log('Error response:', xhr.responseText);
					$('.timein').replaceWith('<h4 class="timein text-danger">Error de conexión</h4>');
					setTimeout(function(){ $('#employee-id').focus(); }, 1500);
				}
			})
		},
		TimeOutMorning: function() {
			var self = this;
			var id = $('#employee-id').val();
			var form = { content: this.time_out_morning };
			var link = '/payroll/admin/vue/TimeOutMorning.php';
			$.ajax({
				url: link,
				type: 'post',
				dataType: 'json',
				data: form,
				success: function(data){
					if(data && data.status === 'success'){
						$('.timein').replaceWith('<h4 class="timein text-success">Salida registrada: ID-'+ id +' </h4>');
						self.time_out_morning = '';
						$('#employee-id').val('');
						$('#employee-id').focus();
						setTimeout(function(){
							$('.timein').replaceWith(self.original_timein_html || '<h4 class="timein">Tiempo de salida Matutina</h4>');
						}, 2500);
					} else {
						var msg = (data && data.message) ? data.message : 'Error al registrar salida';
						$('.timein').replaceWith('<h4 class="timein text-danger">'+ msg +'</h4>');
						setTimeout(function(){ $('#employee-id').focus(); }, 1500);
					}
				},
				error: function(){
					$('.timein').replaceWith('<h4 class="timein text-danger">Error de conexión</h4>');
					setTimeout(function(){ $('#employee-id').focus(); }, 1500);
				}
			})
		},
		TimeInAfternoon: function() {
			var self = this;
			var id = $('#employee-id').val();
			var form = { content: this.time_in_afternoon };
			var link = '/payroll/admin/vue/TimeInAfternoon.php';
			$.ajax({
				url: link,
				type: 'post',
				dataType: 'json',
				data: form,
				success: function(data){
					if(data && data.status === 'success'){
						self.time_in_afternoon = '';
						$('.timein').replaceWith('<h4 class="timein text-success">Entrada registrada: ID-'+ id +' </h4>');
						$('#employee-id').val('');
						$('#employee-id').focus();
						setTimeout(function(){
							$('.timein').replaceWith(self.original_timein_html || '<h4 class="timein">Tiempo de entrada vespertina</h4>');
						}, 2500);
					} else {
						var msg = (data && data.message) ? data.message : 'Error al registrar entrada';
						$('.timein').replaceWith('<h4 class="timein text-danger">'+ msg +'</h4>');
						setTimeout(function(){ $('#employee-id').focus(); }, 1500);
					}
				},
				error: function(){
					$('.timein').replaceWith('<h4 class="timein text-danger">Error de conexión</h4>');
					setTimeout(function(){ $('#employee-id').focus(); }, 1500);
				}
			})
		},
		TimeOutAfternoon: function() {
			var self = this;
			var id = $('#employee-id').val();
			var form = { content: this.time_out_afternoon };
			var link = '/payroll/admin/vue/TimeOutAfternoon.php';
			$.ajax({
				url: link,
				type: 'post',
				dataType: 'json',
				data: form,
				success: function(data){
					if(data && data.status === 'success'){
						$('.timein').replaceWith('<h4 class="timein text-success">Salida registrada: ID-'+ id +' </h4>');
						self.time_out_afternoon = '';
						$('#employee-id').val('');
						$('#employee-id').focus();
						setTimeout(function(){
							$('.timein').replaceWith(self.original_timein_html || '<h4 class="timein">Tiempo de salida vespertina</h4>');
						}, 2500);
					} else {
						var msg = (data && data.message) ? data.message : 'Error al registrar salida';
						$('.timein').replaceWith('<h4 class="timein text-danger">'+ msg +'</h4>');
						setTimeout(function(){ $('#employee-id').focus(); }, 1500);
					}
				},
				error: function(){
					$('.timein').replaceWith('<h4 class="timein text-danger">Error de conexión</h4>');
					setTimeout(function(){ $('#employee-id').focus(); }, 1500);
				}
			})
		},
	}
})