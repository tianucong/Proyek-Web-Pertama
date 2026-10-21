<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Todo List Saya</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  </head>

  <body class="bg-slate-100 min-h-screen font-sans text-slate-800">

@verbatim
    <div id="app">
      <!-- buat bagian nav atas nya-->

      <nav class="bg-white border-b-2 border-slate-200 shadow-sm py-4 mb-8">
        <div class="relative flex justify-center items-center px-4">
        <div class="flex gap-6">  
        <button
            @click="menuAktif='progress'"
            :class="menuAktif==='progress'?'bg-blue-50 text-blue-600 rounded-xl justify-center py-2 px-2 ' : 'text-slate-500 hover:bg-slate-50'"
            class="font-bold pb-2 transition-all"
          >
            Your Progress
          </button>

          <button
            @click="menuAktif='todo'"
            :class="menuAktif==='todo'?'bg-blue-50 text-blue-600 rounded-xl justify-center py-2 px-2 ' : 'text-slate-500 hover:bg-slate-50'"
            class="font-bold pb-2 transition-all"
          >
            Todo List
          </button>

          <button
            @click="menuAktif='counter'"
            :class="menuAktif==='counter'?'bg-blue-50 text-blue-600 rounded-xl justify-center py-2 px-2 ' : 'text-slate-500 hover:bg-slate-50'"
            class="font-bold pb-2 transition-all"
          >
            Character & Word Counter
          </button>
          </div>
          @endverbatim
        <div class="absolute right-4 flex items-center gap-4">
          <span class="text-sm font-semibold text-slate-700">Halo, {{ auth()->user()->name }}</span>
          <form method="POST" action="/logout" class="m-0">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all">
              Logout
            </button>
          </form>
        </div>
        @verbatim
        </div>
      </nav>

      <!--untuk konten yang ditampilkan dibawah-->

      <div class="px-6 md:px-12 w-full">
        <main
          class="max-w-full mx-auto bg-white p-8 rounded-2xl shadow-md border border-slate-100"
        >
          <!-- buat menu progress -->

          <!--bagian kiri-->

          <div
            v-if="menuAktif==='progress'"
            class="flex flex-col lg:flex-row gap-8"
          >
            <div class="lg:w-1/3 flex flex-col gap-6">
              <div
                class="bg-slate-50 rounded-2xl flex flex-items-center shadow-md border-slate-200 p-6 min-h-[150px]"
              >
                <h3 class="font-bold text-lg text-slate-700 mb-4">
                  Profil Saya
                </h3>
                <p class="text-slate-400 text-sm text-center mt-4">
                  Konten profil akan dibuat di sini
                </p>
              </div>

              <div
                class="bg-slate-50 p-6 rounded-2xl shadow-sm border border-slate-200 min-h-[250px] flex flex-col items-center justify-center"
              >
                <h3 class="font-bold text-lg text-slate-700 mb-4 text-center">
                  Statistik Seluruhnya
                </h3>

                <div
                  class="relative w-40 h-40 flex justify-center items-center"
                >
                  <svg
                    class="w-full h-full transform -rotate-90"
                    viewBox="0 0 100 100"
                  >
                    <circle
                      cx="50"
                      cy="50"
                      r="40"
                      fill="transparent"
                      stroke="#e2e8f0"
                      stroke-width="12"
                    />
                    <circle
                      cx="50"
                      cy="50"
                      r="40"
                      fill="transparent"
                      stroke="#f97316"
                      stroke-width="12"
                      stroke-linecap="round"
                      :stroke-dasharray="251.2"
                      :stroke-dashoffset="251.2 - (251.2 * persentaseTotal) / 100"
                      class="transition-all duration-1000 ease-out"
                    />
                  </svg>

                  <div
                    class="absolute flex flex-col items-center justify-center"
                  >
                    <span
                      class="text-3xl font-extrabold text-slate-800 text-center"
                      >{{persentaseTotal}} %</span
                    >
                    <span class="text-xs font-medium text-slate-500 text-center"
                      >Total</span
                    >
                  </div>
                </div>
              </div>
            </div>

            <!--bagian kanannya-->

            <div class="lg:w-2/3 flex flex-col gap-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                  class="bg-slate-100 p-6 rounded-2xl shadow-md border border-slate-200 flex flex-col items-center justify-center"
                >
                  <p class="text-slate-800 font-semibold mb-2">Total task</p>
                  <span class="4xl font-bold text-slate-800"
                    >{{ totalTask }}</span
                  >
                </div>

                <div
                  class="bg-slate-100 p-6 rounded-2xl shadow-md border border-slate-200 flex flex-col items-center justify-center"
                >
                  <p class="text-slate-800 font-semibold mb-2">Task Selesai</p>
                  <span class="4xl font-bold text-slate-800"
                    >{{ taskSelesai }}</span
                  >
                </div>

                <div
                  class="bg-slate-100 p-6 rounded-2xl shadow-md border border-slate-200 flex flex-col items-center justify-center"
                >
                  <p class="text-slate-800 font-semibold mb-2">
                    Task Belum Selesai
                  </p>
                  <span class="4xl font-bold text-slate-800"
                    >{{ taskBelumSelesai }}</span
                  >
                </div>
              </div>

              <!--bagian progress bar per task-->

              <div
                class="bg-slate-50 p-6 shadow-md border border-slate-200 rounded-2xl min-h-[400px] overflow-y-auto relative"
              >
                <div
                  class="sticky top-0 bg-slate-50 pb-4 mb-2 border-b border-slate-200"
                >
                  <h3 class="font-bold text-lg text-slate-700">
                    Progres per Kategori (List)
                  </h3>
                </div>

                <div class="w-full h-full">
                  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div
                      v-for="list in kumpulanList"
                      :key="list.id"
                      class="bg-white order border-slate-200 rounded-xl shadow-sm p-4 flex flex-col items-center text-center"
                    >
                      <h4 class="font-bold text-slate-400 text-lg mb-2">
                        {{list.nama}}
                      </h4>
                      <span
                        class="font-bold text-slate-300 text-md truncate w-full"
                        >{{hitungPersentasePerList(list)}}%</span
                      >
                      <div
                        class="relative w-28 h-16 flex justify-center items-center overflow-hidden"
                      >
                        <svg
                          class="w-full h-full transform -rotate-90"
                          viewBox="0 0 100 100"
                        >
                          <circle
                            cx="50"
                            cy="50"
                            r="40"
                            fill="transparent"
                            stroke="#e2e8f0"
                            stroke-width="12"
                          />
                          <circle
                            cx="50"
                            cy="50"
                            r="40"
                            fill="transparent"
                            stroke="#22c55e"
                            stroke-width="12"
                            stroke-linecap="round"
                            :stroke-dasharray="251.2"
                            :stroke-dashoffset="251.2 - (251.2 * hitungPersentasePerList(list)) / 100"
                            class="transition-all duration-700 ease-out"
                          />
                        </svg>
                      </div>

                      <p class="text-slate-300 text-sm font-medium mt-3">
                        {{list.tugas.filter(x=>x.selesai).length}} /
                        {{list.tugas.length}} task selesai
                      </p>
                    </div>
                    <div
                      v-if="kumpulanList.length===0"
                      class="text-center py-10 text-slate-400 font-medium"
                    >
                      Belum ada list yang dibuat.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- buat menu todo list -->
          <div
            v-if="menuAktif === 'todo'"
            class="flex flex-col md:flex-row gap-8"
          >
            <!--bagian kiri-->
            <div
              class="md:w-1/3 bg-slate-100 border border-slate-200 rounded-2xl p-4 flex flex-col h-fit"
            >
              <button
                @click="tambahListBaru"
                class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-xl mb-4 transition-colors shadow-md"
              >
                + New List
              </button>

              <ul v-if="kumpulanList.length> 0" class="space-y-2">
                <li
                  v-for="list in kumpulanList"
                  :key="list.id"
                  @click="listAktif = list"
                  :class="listAktif.id === list.id ? 'bg-blue-100 text-blue-700 font-bold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-200'"
                  class="cursor-pointer p-3 rounded-lg transition-all flex justify-between items-center select-none"
                >
                  {{ list.nama }}
                </li>
              </ul>
              <div
                v-else
                class="text-center py-6 text-slate-400 text-sm font-medium"
              >
                Belum ada list. Klik tombol di atas untuk membuat!
              </div>
            </div>

            <!--bagian kanannya-->
            <div v-if="listAktif" class="flex-1 justify-center">
              <h2 class="text-2xl font-bold mb-6">{{ listAktif.nama }}</h2>

              <div class="full-width flex gap-3 mb-6">
                <!-- bagian input tugasnya-->
                <input
                  v-model="tugasBaru"
                  @keyup.enter="tambahTugas"
                  type="text"
                  id="todo-input"
                  maxlength="20"
                  placeholder=" Tulis tugas anda ..."
                  class="flex-1 px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500 transition-colors"
                />
                <input
                  v-model="waktuBaru"
                  type="text"
                  placeholder="Kapan?"
                  onfocus="this.type = 'datetime-local'"
                  onblur="
                    this.value === ''
                      ? (this.type = 'text')
                      : (this.type = 'datetime-local')
                  "
                  class="px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500 transition-colors text-slate-600 cursor-pointer"
                />

                <button
                  @click="tambahTugas"
                  class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md hover:shadow-lg"
                >
                  Tambah
                </button>
              </div>

              <!--bagian bawah-->

              <ul class="space-y-3">
                <li
                  v-for="tugas in tugasTersortir"
                  :key="tugas.id"
                  class="flex justify-between items-center py-1 p-4 bg-slate-50 rounded-xl border-l-4 border-blue-500 shadow-sm"
                >
                  <div class="flex items-center gap-3">
                    <div
                      @click="coretTugas(tugas.id)"
                      :class="tugas.selesai ? 'bg-white border-green-500' : 'bg-white border-slate-300'"
                      class="w-6 h-6 rounded-full border-2 flex items-center justify-center cursor-pointer transition-colors shrink-0 shadow-sm"
                    >
                      <svg
                        v-if="tugas.selesai"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m4.5 12.75 6 6 9-13.5"
                        />
                      </svg>
                    </div>

                    <span
                      @click="coretTugas(tugas.id)"
                      :class="{'line-through text-slate-300 font-italic': tugas.selesai}"
                      class="cursor-pointer font-medium text-slate-700 transition-all select-none"
                    >
                      {{ tugas.teks}}
                    </span>
                  </div>

                  <div class="flex items-center gap-4">
                    <span
                      v-if="tugas.waktu"
                      class="text-sm text-slate-500 mt-1 font-medium"
                    >
                      Due : {{tugas.waktu.replace('T',' ')}}
                    </span>

                    <button
                      @click="hapusTugas(tugas.id)"
                      class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 text-sm font-semibold rounded-lg shrink-0"
                    >
                      Hapus
                    </button>
                  </div>
                </li>
              </ul>
              <p
                v-if="listAktif.tugas.length === 0"
                class="text-center text-slate-400 mt-8"
              >
                Belum ada tugas di kegiatan ini. Tambahkan di atas!
              </p>
            </div>
            <div
              v-else
              class="md:w-2/3 flex items-center justify-center text-slate-400 font-medium"
            >
              Pilih atau buat kategori list terlebih dahulu di sebelah kiri.
            </div>
          </div>
          <div v-if="menuAktif==='counter'">
            <h2
              class="text-3xl text-center font-extrabold text-slate-800 mb-6 p-4"
            >
              Character & Word Counter
            </h2>

            <textarea
              v-model="teksInput"
              placehoder="Tulis Sesuatu"
              class="w-full p-4 h-64 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500 transition-colors resize-none mb-4"
            ></textarea>

            <div
              class="bg-blue-100 p-4 rounded-xl border border-slate-200 gap-6 text-sm font-semibold text-slate-600"
            >
              <p>Jumlah Karakter :</p>
              <span class="text-blue-500">{{ jumlahKarakter }}</span>

              <p>Jumlah Kata :</p>
              <span class="text-blue-500">{{ jumlahKata }}</span>
            </div>
          </div>
        </main>
      </div>
    </div>

    <script>
      const { createApp, ref, computed, watch, onMounted } = Vue;
      createApp({
        setup() {


 async function api(url, method = "GET", body = null) {
  const respon = await fetch(url, {
    method: method,
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
    },
    body: body ? JSON.stringify(body) : null,
  });

  if (!respon.ok) {
    alert("Gagal menghubungi server (kode " + respon.status + ")");
    throw new Error("Request gagal: " + respon.status);
  }

  return respon.status === 204 ? null : respon.json();
}



          const kumpulanList = ref([]);
          const listAktif = ref(null);
          onMounted(async () => {
        kumpulanList.value = await api("/api/lists");
        if (kumpulanList.value.length > 0) {
          listAktif.value = kumpulanList.value[0];
          }
          });
          const tugasBaru = ref("");
          const daftarTugas = ref([]);
          const menuAktif = ref("todo");
          const teksInput = ref("");
          const jumlahKarakter = computed(() => {
            return teksInput.value.length;
          });
          const waktuBaru = ref("");
          const jumlahKata = computed(() => {
            const kata = teksInput.value.match(/\S+/g);
            return kata ? kata.length : 0;
          });
          const totalTask = computed(() => {
            let totalTask = 0;
            for (let i = 0; i < kumpulanList.value.length; i++) {
              totalTask += kumpulanList.value[i].tugas.length;
            }
            return totalTask;
          });
          const taskSelesai = computed(() => {
            let jumlahSelesai = 0;
            for (let i = 0; i < kumpulanList.value.length; i++) {
              for (let j = 0; j < kumpulanList.value[i].tugas.length; j++) {
                if (kumpulanList.value[i].tugas[j].selesai) {
                  jumlahSelesai++;
                }
              }
            }
            return jumlahSelesai;
          });

          const taskBelumSelesai = computed(() => {
            return totalTask.value - taskSelesai.value;
          });

          const persentaseTotal = computed(() => {
            if (totalTask.value === 0) return 0;

            return Math.round((taskSelesai.value / totalTask.value) * 100);
          });

          


          function hitungPersentasePerList(list) {
            let total = list.tugas.length;
            if (total === 0) return 0;
            let selesai = list.tugas.filter((x) => x.selesai).length;
            return Math.round((selesai / total) * 100);
          }

  async function tambahListBaru() {
  const namaBaru = prompt("Masukkan nama list baru");
  if (namaBaru && namaBaru.trim() !== "") {
    if (namaBaru.length > 20) {
      return alert("Panjang max 20 karakter");
    }
    const listBaru = await api("/api/lists", "POST", { nama: namaBaru.trim() });
    kumpulanList.value.push(listBaru);
    listAktif.value = listBaru;
  }
}
          async function tambahTugas(){
            if(tugasBaru.value.trim()==="")return alert("Isi dulu bro!");
            const list = listAktif.value;
            const tugasDariSever=await api(`/api/lists/${list.id}/tasks`,"POST",{
              teks:tugasBaru.value,
              waktu:waktuBaru.value,
            });
            list.tugas.push(tugasDariServer);
            tugasBaru.value="";
            waktuBaru.value="";
          }
         
          async function hapusTugas(idTugas) {
            await api(`/api/tasks/${idTugas}`,"DELETE");
            const index=listAktif.value.tugas.findIndex((x)=>x.id==idTugas);
            if(index !==-1){
              listAktif.value.tugas.splice(index,1);
            }
          }

          async function coretTugas(idTugas) {
            const tugas = listAktif.value.tugas.find((x) => x.id === idTugas);
            if(!tugas) return;
            const nilaiBaru=!tugas.selesai;
            await api(`/api/tasks/${idTugas})`,"PATCH",{selesai:nilaiBaru});
            tugas.selesai=nilaiBaru;
}

          const tugasTersortir = computed(() => {
            if (!listAktif.value) return [];
            return [...listAktif.value.tugas].sort((a, b) => {
              if (a.selesai !== b.selesai) return a.selesai ? 1 : -1;
              return new Date(a.waktu) - new Date(b.waktu);
            });
          });

          return {
            kumpulanList,
            listAktif,
            tambahListBaru,
            tugasBaru,
            tambahTugas,
            hapusTugas,
            coretTugas,
            menuAktif,
            jumlahKarakter,
            teksInput,
            waktuBaru,
            tugasTersortir,
            jumlahKata,
            totalTask,
            taskSelesai,
            taskBelumSelesai,
            persentaseTotal,
            hitungPersentasePerList,
          };
        },
      }).mount("#app");
    </script>
    @endverbatim
  </body>
</html>
