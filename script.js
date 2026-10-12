const todoInput = document.getElementById('todo-input');
const addBtn = document.getElementById('add-btn');
const todoList = document.getElementById('todo-list')

function addTask(){
    const taskText=todoInput.value.trim();
    if(taskText===""){
        alert("Silahkan masukkan tugas anda");
        return;
    }
    const li=document.createElement('li');
    li.className = "flex justify-between items-center p-4 bg-slate-50 rounded-xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow";
    li.innerHTML=`<span>${taskText}</span><div><button class="complete-btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 text-sm font-semibold rounded-lg shadow transition-colors">Selesai</button><button class="delete-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 text-sm font-semibold rounded-lg shadow transition-colors">Hapus</button></div>`;

    
        
    const span = li.querySelector('span');
    span.addEventListener('click',function(){
    span.classList.toggle('completed');
    span.classList.toggle('text-slate-800');
});

    const completeBtn = li.querySelector('.complete-btn');
    completeBtn.addEventListener('click', function(){
    li.classList.toggle('completed');
    }); 
       
    const deleteBtn = li.querySelector('.delete-btn');
    deleteBtn.addEventListener('click',function(){
    li.remove();
});

todoList.appendChild(li);
todoInput.value='';
}

addBtn.addEventListener('click',addTask);


todoInput.addEventListener('keypress',function(event){
    if(event.key==='Enter'){
        addTask();
    }
});