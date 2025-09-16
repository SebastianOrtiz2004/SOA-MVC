const API = window.location.origin + "/SOA-MVC/SOA_API/Controller/ApiRest.php";

let datos = [];           
let filtrados = [];       
let seleccionado = null;  

const qs = (s) => document.querySelector(s);
const qsa = (s) => [...document.querySelectorAll(s)];
const toastEl = new bootstrap.Toast(qs("#toast"));
function showToast(msg, color="dark"){
  const t = qs("#toast"); t.className = `toast align-items-center text-bg-${color} border-0`;
  qs("#toastMsg").textContent = msg;
  toastEl.show();
}
function loading(on){
  qs("#loading").style.display = on ? "grid" : "none";
}

function renderTabla(list){
  const tbody = qs("#tablaBody");
  if(!list.length){
    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-secondary py-4">Sin datos</td></tr>`;
    qs("#badgeTotal").textContent = 0;
    return;
  }
  qs("#badgeTotal").textContent = list.length;

  tbody.innerHTML = list.map(r => `
    <tr data-id="${r.cedula}">
      <td class="fw-medium">${r.cedula ?? ""}</td>
      <td>${r.nombre ?? ""}</td>
      <td>${r.apellido ?? ""}</td>
      <td>${r.direccion ?? ""}</td>
      <td>${r.telefono ?? ""}</td>
    </tr>
  `).join("");

  qsa("#tablaBody tr").forEach(tr => {
    tr.addEventListener("click", () => {
      qsa("#tablaBody tr").forEach(x => x.classList.remove("selected"));
      tr.classList.add("selected");
      const id = tr.dataset.id;
      const row = list.find(x => x.cedula === id);
      seleccionado = id;
      setForm(row);
    });
  });
}

async function cargar(){
  try{
    loading(true);
    const res = await fetch(API);
    const data = await res.json();
    datos = Array.isArray(data) ? data : [];
    filtrados = datos;
    renderTabla(filtrados);
  }catch(e){
    showToast("Error al cargar: " + e.message, "danger");
  }finally{
    loading(false);
  }
}

qs("#txtBuscar").addEventListener("input", e => {
  const q = e.target.value.trim().toLowerCase();
  filtrados = !q ? datos : datos.filter(r =>
    (r.cedula || "").toLowerCase().includes(q) ||
    (r.nombre || "").toLowerCase().includes(q) ||
    (r.apellido || "").toLowerCase().includes(q)
  );
  renderTabla(filtrados);
});

function getForm(){
  return {
    cedula: qs("#cedula").value.trim(),
    nombre: qs("#nombre").value.trim(),
    apellido: qs("#apellido").value.trim(),
    direccion: qs("#direccion").value.trim(),
    telefono: qs("#telefono").value.trim(),
  };
}
function setForm(d){
  qs("#cedula").value    = d?.cedula    ?? "";
  qs("#nombre").value    = d?.nombre    ?? "";
  qs("#apellido").value  = d?.apellido  ?? "";
  qs("#direccion").value = d?.direccion ?? "";
  qs("#telefono").value  = d?.telefono  ?? "";
}
function limpiar(){
  seleccionado = null;
  setForm({});
  qsa("#tablaBody tr").forEach(x => x.classList.remove("selected"));
}
qs("#btnLimpiar").addEventListener("click", limpiar);

async function crear(){
  const f = qs("#frm");
  if(!f.checkValidity()){ f.classList.add("was-validated"); return; }
  const d = getForm();
  try{
    loading(true);
    const r = await fetch(API, {
      method: "POST",
      headers: {"Content-Type":"application/json;charset=utf-8"},
      body: JSON.stringify(d)
    }).then(x => x.json());
    if(r.success){ showToast("Creado correctamente","success"); await cargar(); limpiar(); }
    else showToast(r.error || "No se pudo crear","danger");
  }catch(e){ showToast(e.message,"danger"); }
  finally{ loading(false); }
}

async function actualizar(){
  const d = getForm();
  if(!d.cedula){ showToast("La cédula es obligatoria","warning"); return; }
  try{
    loading(true);
    const r = await fetch(API, {
      method: "PUT",
      headers: {"Content-Type":"application/json;charset=utf-8"},
      body: JSON.stringify(d)
    }).then(x => x.json());
    if(r.success){ showToast("Actualizado","success"); await cargar(); }
    else showToast(r.error || "No se pudo actualizar","danger");
  }catch(e){ showToast(e.message,"danger"); }
  finally{ loading(false); }
}

async function eliminar(){
  const ced = qs("#cedula").value.trim();
  if(!ced){ showToast("Selecciona o escribe una cédula","warning"); return; }
  if(!confirm("¿Eliminar registro?")) return;
  try{
    loading(true);
    const r = await fetch(`${API}?cedula=${encodeURIComponent(ced)}`, { method: "DELETE" }).then(x => x.json());
    if(r.success){ showToast("Eliminado","success"); await cargar(); limpiar(); }
    else showToast(r.error || "No se pudo eliminar","danger");
  }catch(e){ showToast(e.message,"danger"); }
  finally{ loading(false); }
}

qs("#btnCrear").addEventListener("click", crear);
qs("#btnActualizar").addEventListener("click", actualizar);
qs("#btnEliminar").addEventListener("click", eliminar);
qs("#btnRecargar").addEventListener("click", cargar);

document.addEventListener("DOMContentLoaded", cargar);