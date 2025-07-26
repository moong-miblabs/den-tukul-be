class Ref {
	constructor(val) {
		this.value = val
	}
}

function linkert(char) {
    if(char=='SS') return 4
    if(char=='SR') return 3
    if(char=='KD') return 2
    if(char=='TP') return 1
}

const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Jika saya batuk berdahak selama lebih dari 2 minggu, saya memakai masker.",
	"Saya selalu menutup mulut dengan tisu atau tangan saat batuk atau bersin.",
	"Saya memakai masker kalau sedang bepergian.",
	"Saya membuka jendela atau pintu agar udara segar bisa masuk ke dalam rumah.",
	"Saya memastikan rumah mendapat cahaya matahari yang cukup setiap hari.",
	"Saya membuang dahak di tempat khusus atau saluran air, bukan di sembarang tempat.",
	"Saat ada teman yang sedang batuk, saya menjaga jarak darinya.",
	"Jika saya batuk berdahak, saya pergi periksa ke puskesmas atau tempat layanan kesehatan.",
	"Saat batuk berdahak, saya selalu memakai masker agar tidak menular ke orang lain.",
	"Jika saya sakit, saya memakai alat makan sendiri (tidak berbagi dengan orang lain)."
]

const es01 = ref(null)
const es02 = ref(null)
const es03 = ref(null)
const es04 = ref(null)
const es05 = ref(null)
const es06 = ref(null)
const es07 = ref(null)
const es08 = ref(null)
const es09 = ref(null)
const es10 = ref(null)

var data = [
	{ tipe: "es", n: 1, a: es01.value, s: linkert(es01.value) },
	{ tipe: "es", n: 2, a: es02.value, s: linkert(es02.value) },
	{ tipe: "es", n: 3, a: es03.value, s: linkert(es03.value) },
	{ tipe: "es", n: 4, a: es04.value, s: linkert(es04.value) },
	{ tipe: "es", n: 5, a: es05.value, s: linkert(es05.value) },
	{ tipe: "es", n: 6, a: es06.value, s: linkert(es06.value) },
	{ tipe: "es", n: 7, a: es07.value, s: linkert(es07.value) },
	{ tipe: "es", n: 8, a: es08.value, s: linkert(es08.value) },
	{ tipe: "es", n: 9, a: es09.value, s: linkert(es09.value) },
	{ tipe: "es", n: 10, a: es10.value, s: linkert(es10.value) }
]

console.log(data)