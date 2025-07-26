class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Saya menutup mulut saat bersin atau batuk.",
	"Saya memakai masker jika sedang batuk.",
	"Saya tidak meludah di sembarang tempat.",
	"Saya pergi ke ruang UKS jika saya batuk terus-menerus.",
	"Jika saya merasa lemas, tidak nafsu makan, atau berat badan turun, saya melapor ke guru atau petugas UKS."
]

const ep1 = ref(null)
const ep2 = ref(null)
const ep3 = ref(null)
const ep4 = ref(null)
const ep5 = ref(null)

var data = [
	{ tipe: "ep", n: 1, a: ep1.value, s: ep1.value=='Y'?1:0 },
	{ tipe: "ep", n: 2, a: ep2.value, s: ep2.value=='Y'?1:0 },
	{ tipe: "ep", n: 3, a: ep3.value, s: ep3.value=='Y'?1:0 },
	{ tipe: "ep", n: 4, a: ep4.value, s: ep4.value=='Y'?1:0 },
	{ tipe: "ep", n: 5, a: ep5.value, s: ep5.value=='Y'?1:0 }
]

console.log(data)