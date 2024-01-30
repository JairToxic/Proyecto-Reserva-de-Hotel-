// scripts.js
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        dateClick: function(info) {
            alert('Fecha seleccionada: ' + info.dateStr);
            // Aquí puedes implementar la lógica para realizar la reserva
            // por ejemplo, mostrando un formulario de reserva con la fecha seleccionada
        }
    });
    calendar.render();
});
