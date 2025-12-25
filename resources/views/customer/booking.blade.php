<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking - Bosque Barbershop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        .calendar-cell { padding: .6rem; border-radius: .5rem; cursor: pointer; }
        .calendar-cell:hover { background: rgba(0,0,0,.05); }
        .calendar-today { background: #fef3c7; }
        .calendar-selected { background: #6b7280; color: #fff; }

        .timeslot { padding: .6rem 1rem; border-radius: .5rem; border:1px solid rgba(0,0,0,.08); cursor:pointer; }
        .timeslot:hover { background: rgba(0,0,0,.05); }
        .timeslot-selected { background:#6b7280; color:#fff; border-color:transparent; }
        .timeslot-booked { background:#e5e7eb; color:#6b7280; border-color:transparent; cursor:not-allowed; }

        .bg-card { background: rgba(255,255,255,.6); }
        .card-hover { transition:.2s ease; }
        .card-hover:hover { transform:translateY(-6px); box-shadow:0 18px 30px rgba(0,0,0,.1); }
    </style>
</head>

<body class="relative bg-cover bg-center bg-fixed text-gray-800"
      style="background-image:url('{{ asset('images/bg-booking.jpg') }}');">

    <div class="absolute inset-0 bg-white bg-opacity-60"></div>

    <div x-data="bookingForm()" x-init="generateCalendar()" class="relative max-w-6xl mx-auto py-10 px-4 z-10">

        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold">Book Your Appointment</h1>
                <p class="text-gray-700">Hi, <b>{{ $user->name ?? 'Guest' }}</b></p>
            </div>

            <!-- Tombol My Booking (Styled Premium) -->
            <a href="{{ route('bookings.index') }}"
               class="bg-[#1E2635] text-white px-6 py-2 rounded-full shadow-md hover:bg-[#141A26] transition font-semibold">
               My Booking
            </a>
        </div>

        <!-- STEP 1: Store -->
        <div x-show="step === 1" x-cloak class="text-center">
            <h2 class="text-2xl font-semibold mb-8">Pilih Store</h2>
            <div class="flex justify-center">
                <div class="p-8 bg-card rounded-2xl shadow card-hover max-w-sm">
                    <img src="{{ asset('images/store/tasik.png') }}" class="w-56 mx-auto">
                    <h3 class="text-2xl font-bold mt-4">TASIKMALAYA</h3>
                    <p class="text-gray-700 text-sm">Jl. Cikalang Girang No.48 G, Tasikmalaya 08157123448</p>
                    <button @click="chooseStore('Tasikmalaya')" class="bg-gray-800 text-white px-6 py-2 rounded-full mt-6">Pilih</button>
                </div>
            </div>
        </div>

        <!-- STEP 2: Gender -->
        <div x-show="step === 2" x-cloak class="text-center pt-16 relative">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-800 text-white px-4 py-2 rounded-full">← Kembali</button>
            <h2 class="text-2xl mb-8">Pilih Gender</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mx-auto max-w-xl">
                <div @click="chooseGender('Male')" class="bg-card p-6 rounded-2xl shadow cursor-pointer card-hover">
                    <img src="{{ asset('images/gender/male.png') }}" class="w-48 mx-auto">
                    <p class="mt-3 font-semibold text-xl">Male</p>
                </div>
                <div @click="chooseGender('Female')" class="bg-card p-6 rounded-2xl shadow cursor-pointer card-hover">
                    <img src="{{ asset('images/gender/female.png') }}" class="w-48 mx-auto">
                    <p class="mt-3 font-semibold text-xl">Female</p>
                </div>
            </div>
        </div>

        <!-- STEP 3: Service (BESAR) -->
        <div x-show="step === 3" x-cloak class="text-center pt-16 relative">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-800 text-white px-4 py-2 rounded-full">← Kembali</button>

            <h2 class="text-2xl font-semibold mb-8">Pilih Service</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <template x-for="s in services">
                    <div @click="chooseService(s.name)"
                         class="bg-card p-10 rounded-3xl cursor-pointer card-hover text-center min-h-[260px] flex flex-col items-center justify-center shadow-lg">
                        
                        <img :src="s.image" class="w-32 mx-auto mb-4">

                        <h3 class="font-semibold text-2xl" x-text="s.name"></h3>
                    </div>
                </template>
            </div>
        </div>

        <!-- STEP 4: Sub Service -->
        <div x-show="step === 4" x-cloak class="text-center relative pt-16">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-700 text-white rounded-full px-4 py-2">← Kembali</button>

            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-yellow-600">
                        Pilih Sub Layanan untuk <span class="text-black" x-text="service"></span>
                    </h1>
                    <p class="text-gray-700 mt-2">Pilih salah satu sub layanan berikut:</p>
                </div>

                <div class="grid gap-8"
                     :class="service==='Haircare & Extras'?'justify-center max-w-xl mx-auto grid-cols-1 sm:grid-cols-2':'grid-cols-1 sm:grid-cols-2 md:grid-cols-3'">

                    <template x-for="(item,i) in (subServices[service]||[]).filter(s=>s && s.name)" :key="i">

                        <div @click="chooseSubService(item)"
                             class="cursor-pointer bg-card rounded-2xl shadow-lg p-10 card-hover border-2 flex flex-col items-center justify-center min-h-[260px]"
                             :class="{'border-gray-500 ring-4 ring-gray-400 shadow-xl scale-[1.04]': sub_service===item.name}">
                            
                            <img :src="item.image" class="w-32 h-32 object-contain mb-4"/>
                            <h3 class="font-bold text-3xl mb-2 leading-tight" x-text="item.name"></h3>
                            <p class="text-green-600 font-bold text-2xl" x-text="'Rp '+item.price.toLocaleString()"></p>

                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- STEP 5: Barber -->
        <div x-show="step === 5" x-cloak class="text-center pt-16 relative">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-800 text-white px-4 py-2 rounded-full">← Kembali</button>
            <h2 class="text-2xl font-semibold mb-8">Pilih Barber</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <template x-for="b in barbers">
                    <div @click="chooseBarber(b.name)"
                         class="bg-card p-6 rounded-2xl cursor-pointer card-hover text-center"
                         :class="{'ring-4 ring-gray-500': barber===b.name}">

                        <img :src="b.image" class="w-40 h-40 rounded-full object-cover mx-auto">
                        <p class="mt-4 font-semibold text-lg" x-text="b.name"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- STEP 6: Date & Time -->
        <div x-show="step === 6" x-cloak class="pt-16 relative max-w-4xl mx-auto text-center">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-800 text-white px-4 py-2 rounded-full">← Kembali</button>

            <h2 class="text-2xl font-semibold mb-6">Pilih Tanggal & Jam</h2>

            <div class="flex flex-col md:flex-row gap-6 justify-center">
                <div class="bg-card p-6 rounded-2xl shadow w-full md:w-2/3">
                    <div class="flex justify-between mb-4">
                        <button @click="prevMonth">‹</button>
                        <b x-text="monthName()+' '+year"></b>
                        <button @click="nextMonth">›</button>
                    </div>

                    <div class="grid grid-cols-7 font-semibold text-gray-700">
                        <template x-for="d in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']"><div x-text="d"></div></template>
                    </div>

                    <div class="grid grid-cols-7 gap-2 mt-2">
                        <template x-for="(_) in blanks"><div></div></template>

                        <template x-for="d in days">
                            <div @click="selectDate(d)" class="calendar-cell text-center"
                                 :class="{'calendar-today':isToday(d),'calendar-selected':date===formatDate(d)}"
                                 x-text="d"></div>
                        </template>
                    </div>
                </div>

                <div class="bg-card p-6 rounded-2xl shadow w-full md:w-1/3">
                    <h3 class="font-semibold mb-4">Waktu Tersedia</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <template x-for="t in timeSlots">
                            <button @click="!bookedSlots.includes(t)&&selectTime(t)"
                                    :disabled="bookedSlots.includes(t)"
                                    class="timeslot"
                                    :class="{'timeslot-selected':time===t,'timeslot-booked':bookedSlots.includes(t)}"
                                    x-text="t"></button>
                        </template>
                    </div>
                </div>
            </div>

            <button @click="if(!date||!time){alert('Pilih tanggal & jam!');return;} step++"
                    class="bg-gray-800 text-white mt-6 px-6 py-3 rounded-full">Lanjut</button>
        </div>

        <!-- STEP 7: Confirm -->
        <div x-show="step === 7" x-cloak class="max-w-md mx-auto text-center pt-16 relative">
            <button @click="step--" class="absolute left-0 top-0 bg-gray-800 text-white px-4 py-2 rounded-full">← Kembali</button>

            <h2 class="text-2xl mb-6">Konfirmasi</h2>

            <div class="bg-card p-6 rounded-2xl shadow text-left mb-4">
                <p><b>Store:</b> <span x-text="store"></span></p>
                <p><b>Gender:</b> <span x-text="gender"></span></p>
                <p><b>Service:</b> <span x-text="service"></span></p>
                <p><b>Sub Service:</b> <span x-text="sub_service"></span></p>
                <p><b>Barber:</b> <span x-text="barber"></span></p>
                <p><b>Date:</b> <span x-text="date"></span></p>
                <p><b>Time:</b> <span x-text="time"></span></p>
                <p><b>Price:</b> Rp <span x-text="price.toLocaleString()"></span></p>
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label class="block font-medium">Nama</label>
                <input type="text" x-model="name" class="w-full border p-2 rounded" placeholder="Masukkan nama">
            </div>

            <!-- HP -->
            <div class="mb-4">
                <label class="block font-medium">No HP</label>
                <input type="text" x-model="phone" class="w-full border p-2 rounded" placeholder="Masukkan nomor HP">
            </div>

            <form action="{{ route('book.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="store" x-model="store">
                <input type="hidden" name="gender" x-model="gender">
                <input type="hidden" name="service" x-model="service">
                <input type="hidden" name="sub_service" x-model="sub_service">
                <input type="hidden" name="price" x-model="price">
                <input type="hidden" name="barber" x-model="barber">
                <input type="hidden" name="date" x-model="date">
                <input type="hidden" name="time" x-model="time">
                <input type="hidden" name="name" x-model="name">
                <input type="hidden" name="phone" x-model="phone">

                <button type="submit" :disabled="!name.trim() || !phone.trim()"
                        class="bg-green-600 text-white w-full py-3 rounded-full disabled:opacity-50">
                    Confirm Booking
                </button>
            </form>
        </div>

    </div>

    <script>
        function bookingForm() {
            return {
                step: 1,
                store: "", gender:"", service:"", sub_service:"", barber:"", date:"", time:"", price:0,
                name: "{{ $user->name ?? '' }}",
                phone: "{{ $user->phone ?? '' }}",

                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                days: [], blanks: [],

                timeSlots:["09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00"],
                bookedSlots:[],

                services:[
                    {name:"Haircut", image:"{{ asset('images/services/haircut.png') }}"},
                    {name:"Chemical", image:"{{ asset('images/services/chemical.png') }}"},
                    {name:"Haircare & Extras", image:"{{ asset('images/services/haircare.png') }}"},
                    {name:"Colouring", image:"{{ asset('images/services/coloring.png') }}"},
                ],

                barbers:[
                    {name:"Wandi", image:"{{ asset('images/barbers/wandi.png') }}"},
                    {name:"Fery", image:"{{ asset('images/barbers/fery.png') }}"},
                    {name:"Ajay", image:"{{ asset('images/barbers/ajay.png') }}"},
                    {name:"Sidik", image:"{{ asset('images/barbers/sidik.png') }}"},
                    {name:"Anjas", image:"{{ asset('images/barbers/anjas.jpeg') }}"},
                    {name:"Candra", image:"{{ asset('images/barbers/chandra.png') }}"},
                ],

                subServices:{
                    "Haircut":[
                        {name:"Premium Haircut", price:60000, image:"{{ asset('images/sub/premium.png') }}"},
                        {name:"Kids Haircut", price:50000, image:"{{ asset('images/sub/kids.png') }}"},
                        {name:"Long Haircut", price:80000, image:"{{ asset('images/sub/long.png') }}"},
                    ],
                    "Chemical":[
                        {name:"Hair Perming", price:350000, image:"{{ asset('images/sub/perming.png') }}"},
                        {name:"Smooth & Volumized", price:350000, image:"{{ asset('images/sub/smooth.png') }}"},
                        {name:"Down Perm", price:150000, image:"{{ asset('images/sub/downperm.png') }}"},
                    ],
                    "Haircare & Extras":[
                        {name:"Hair Styling", price:20000, image:"{{ asset('images/sub/styling.png') }}"},
                        {name:"Beard Trim", price:15000, image:"{{ asset('images/sub/beard.png') }}"},
                    ],
                    "Colouring":[
                        {name:"Black Hair Dye", price:60000, image:"{{ asset('images/sub/blackdye.png') }}"},
                        {name:"Hair Coloring Full", price:300000, image:"{{ asset('images/sub/fullcolor.png') }}"},
                        {name:"Highlight", price:250000, image:"{{ asset('images/sub/highlight.png') }}"},
                    ]
                },

                chooseStore(v){this.store=v; this.step=2;},
                chooseGender(v){this.gender=v; this.step=3;},
                chooseService(v){this.service=v; this.sub_service=""; this.step=4;},
                chooseSubService(item){this.sub_service=item.name; this.price=item.price; this.step=5;},
                chooseBarber(v){this.barber=v; this.step=6;},

                generateCalendar(){
                    const firstDay=new Date(this.year,this.month,1).getDay();
                    const total=new Date(this.year,this.month+1,0).getDate();
                    this.blanks = Array(firstDay);
                    this.days = Array.from({ length: total }, (_, i) => i + 1);
                },

                prevMonth() {
                    this.month--;
                    if(this.month < 0){
                        this.month = 11;
                        this.year--;
                    }
                    this.generateCalendar();
                },

                nextMonth() {
                    this.month++;
                    if(this.month > 11){
                        this.month = 0;
                        this.year++;
                    }
                    this.generateCalendar();
                },

                monthName() {
                    return new Date(this.year, this.month).toLocaleString("default", { month: "long" });
                },

                formatDate(d) {
                    return `${this.year}-${String(this.month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                },

                isToday(d) {
                    const n = new Date();
                    return d === n.getDate() && this.month === n.getMonth() && this.year === n.getFullYear();
                },

                selectDate(d) {
                    this.date = this.formatDate(d);
                },

                selectTime(t) {
                    this.time = t;
                },

            };
        }
    </script>

</body>
</html>
