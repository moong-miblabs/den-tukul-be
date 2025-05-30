class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Saya menggunakan masker jika saya mengalami batuk berdahak selama lebih dari 2 minggu",
	"Saya menutup mulut dengan tissue atau saput tangan Saat batuk dan bersin",
	"Saya menggunakan masker pada saat berpergian",
	"Saya membuka pintu dan jendela setiap hari agar udara masuk ke dalam rumah",
	"Saya memastikan seluruh ruangan rumah mendapat sinar matahari yang cukup dipagi hari",
	"Saya membuang dahak pada tempat khusus atau langsung ke saluran air pembuangan",
	"Saya tidak berdekatan  dengan teman Ketika batuk",
	"Saya melakukan pemeriksaan kesehatan di pusat pelayanan kesehatan pada saat saya mengalami batuk berdahak",
	"Saya selalu memakai masker ,ketika saya mengalami batuk berdahak",
	"Saya menggunakan peralatan makan terpisah dengan teman atau keluarga yang lain"
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
	{ tipe: "es", n: 1, a: es01.value },
	{ tipe: "es", n: 2, a: es02.value },
	{ tipe: "es", n: 3, a: es03.value },
	{ tipe: "es", n: 4, a: es04.value },
	{ tipe: "es", n: 5, a: es05.value },
	{ tipe: "es", n: 6, a: es06.value },
	{ tipe: "es", n: 7, a: es07.value },
	{ tipe: "es", n: 8, a: es08.value },
	{ tipe: "es", n: 9, a: es09.value },
	{ tipe: "es", n: 10, a: es10.value }
]

console.log(data)