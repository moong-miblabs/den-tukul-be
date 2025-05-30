class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Saya menutup mulut jika bersin",
	"Saya menggunakan masker bila batuk",
	"Saya tidak meludah sembarang tempat",
	"Saya periksa ke ruang UKS bila batuk-batuk",
	"Badan lemah, nafsu makan menurun, berat badan turun, kurang enak badan melakukan konsultasi dengan guru /PJ UKS"
]

const ep1 = ref(null)
const ep2 = ref(null)
const ep3 = ref(null)
const ep4 = ref(null)
const ep5 = ref(null)

var data = [
	{ tipe: "ep", n: 1, a: ep1.value },
	{ tipe: "ep", n: 2, a: ep2.value },
	{ tipe: "ep", n: 3, a: ep3.value },
	{ tipe: "ep", n: 4, a: ep4.value },
	{ tipe: "ep", n: 5, a: ep5.value }
]

console.log(data)