

function addRoom() {
    const roomsContainer = document.getElementById('roomsContainer');
  
    // Verificar si ya hay 5 habitaciones
    if (roomsContainer.children.length >= 5) {
        alert('¡No puedes agregar más de 5 habitaciones por reserva, por políticas del hotel!');
        return;
    }
  
    const newRoom = document.createElement('div');
    const roomNumber = roomsContainer.children.length + 1;
  
    newRoom.id = `room${roomNumber}`; // Asignar un identificador único
    newRoom.innerHTML = `
      <div class="room">
        <h3>Habitación ${roomNumber}</h3>
        <label for="adults${roomNumber}">Adultos:</label>
        <select id="adults${roomNumber}" name="adults[]"
                onchange="updateChildAges(${roomNumber}, this.value)">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
  
        <label for="children${roomNumber}">Niños:</label>
        <select id="children${roomNumber}" name="children[]"
                onchange="updateChildAges(${roomNumber}, this.value)">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        <div id="childAgesContainer${roomNumber}"></div>
  
        <button type="button" onclick="removeRoom(${roomNumber})" style="margin-top: 10px;">Eliminar Habitación</button>
      </div>
    `;
  
    roomsContainer.appendChild(newRoom);
  
    // Mostrar la sección de habitaciones después de agregar la primera habitación
    if (roomNumber === 1) {
        roomsContainer.style.display = 'block';
    }
  }
  
  function updateChildAges(roomNumber, numChildren) {
    const childAgesContainer = document.getElementById(`childAgesContainer${roomNumber}`);
    const childrenSelect = document.getElementById(`children${roomNumber}`);
  
    // Solo actualizar edades si el número de niños es mayor que 0
    if (childrenSelect && childrenSelect.value > 0) {
        childAgesContainer.innerHTML = '';
  
        for (let i = 1; i <= numChildren; i++) {
            const ageLabel = document.createElement('label');
            ageLabel.textContent = `Edad del niño ${i}:`;
  
            const ageSelect = document.createElement('select');
            ageSelect.name = `childAge${roomNumber}_${i}`;
  
            for (let age = 0; age <= 17; age++) {
                const ageOption = document.createElement('option');
                ageOption.value = age;
                ageOption.textContent = age === 0 ? 'Menos de 1 año' : `${age} años`;
                ageSelect.appendChild(ageOption);
            }
  
            childAgesContainer.appendChild(ageLabel);
            childAgesContainer.appendChild(ageSelect);
            childAgesContainer.appendChild(document.createElement('br'));
        }
    } else {
        // Si el número de niños es 0, limpiar el contenedor
        childAgesContainer.innerHTML = '';
    }
  }
  
  function removeRoom(roomNumber) {
    const roomsContainer = document.getElementById('roomsContainer');
    const roomToRemove = document.getElementById(`room${roomNumber}`);
  
    if (roomToRemove) {
        roomsContainer.removeChild(roomToRemove);
    }
  }
  
  function updateCheckOutMinDate() {
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');
    if (checkInInput && checkOutInput) {
        checkOutInput.min = checkInInput.value; // Actualizar la fecha mínima del check-out
        if (checkOutInput.value < checkInInput.value) {
            // Si la fecha actual del check-out es anterior al check-in, restablecer a la fecha mínima
            checkOutInput.value = checkInInput.value;
        }
    }
  }
  