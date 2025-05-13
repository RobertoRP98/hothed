 <!-- 2 column grid layout with text inputs for the first and last names -->
 @if ($errors->any())
 <div class="alert alert-danger" role="alert">
   <ul>
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
   </ul>
 </div>
 @endif


 <br>
 <div class="row mb-4 col-md-12">
   <div class="col-md-5">
     <div data-mdb-input-init class="form-outline">
      <input type="text" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" class="form-control "  placeholder="Taylor Otwell" />
      <label class="form-label" for="concept">NOMBRE COMPLETO</label>
     </div>
   </div>

   <div class="col-md-5">
    <div class="form-outline">
        <input type="email" id="email" name="email" value="{{ old('email', isset($user) ? $user->email : '' )}}" class="form-control " placeholder="test@hothedmex.mx"/>
        <label class="form-label">CORREO ELECTRONICO</label>
    </div>
    </div>

    <div class="col-md-2">
      <div class="form-outline">
          <input type="text" id="employee_number" name="employee_number" value="{{ old('employee_number', isset($user) ? $user->employee_number : '' )}}" class="form-control " placeholder="001"/>
          <label class="form-label">NUMERO DE EMPLEADO</label>
      </div>
      </div>

 </div>

 <div class="row mb-4 col-md-12">

  <div class="col-md-3">
    <div class="form-outline">
        <select id="area_id" name="area_id" class="form-control">
            <option value="" {{ old('area_id', $user->area_id ?? '') == '' ? 'selected' : '' }}>Sin Área de Trabajo</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" 
                    {{ old('area_id', $user->area_id ?? '') == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="workstation_id">Area de Trabajo</label>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-outline">
        <select id="workstation_id" name="workstation_id" class="form-control">
            <option value="" {{ old('workstation_id', $user->workstation_id ?? '') == '' ? 'selected' : '' }}>Sin Puesto de Trabajo</option>
            @foreach($workstations as $workstation)
                <option value="{{ $workstation->id }}" 
                    {{ old('workstation_id', $user->workstation_id ?? '') == $workstation->id ? 'selected' : '' }}>
                    {{ $workstation->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="workstation_id">Puesto de trabajo</label>
    </div>
</div>

<div class="col-md-4">
    <div class="form-outline">
        <select id="immediate_boss_id" name="immediate_boss_id" class="form-control">
            <option value="" {{ old('immediate_boss_id', $user->immediate_boss_id ?? '') == '' ? 'selected' : '' }}>Sin Jefe Inmediato</option>
            @foreach($users as $boss)
                <option value="{{ $boss->id }}" 
                    {{ old('immediate_boss_id', $user->immediate_boss_id ?? '') == $boss->id ? 'selected' : '' }}>
                    {{ $boss->name }}
                </option>
            @endforeach
        </select>
        <label class="form-label" for="immediate_boss_id">Jefe Inmediato</label>
    </div>
</div>


  <div class="col-md-2">
    <div class="form-outline">
        <select id="active" name="active" class="form-select">
            <option value="1" {{ old('active', isset($user) ? $user->active : 1) == 1 ? 'selected' : '' }}>SI</option>
            <option value="0" {{ old('active', isset($user) ? $user->active : 1) == 0 ? 'selected' : '' }}>NO</option>
        </select>
        <label class="form-label" for="contract">¿EMPLEADO ACTIVO?</label>
    </div>
    </div>
  
</div>


 <!-- Submit button -->
 <button type="submit" class="btn btn-primary btn-block mb-4 m-2">{{$modo}} Usuario</button>

 <button type="button" class="btn btn-warning btn-block mb-3"> <a class="text-white" href="{{ url('users-sgi/') }}">
    Regresar
</a> </button> 