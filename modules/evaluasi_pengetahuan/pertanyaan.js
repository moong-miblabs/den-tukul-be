class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"TB (tuberkulosis) adalah penyakit yang disebabkan oleh kuman yang menyerang paru-paru.",
	"TB bisa menular lewat alat makan seperti sendok dan piring.",
	"Orang yang sakit TB biasanya batuk lama lebih dari 3 minggu, demam, dan seperti flu.",
	"Nyeri dada, sesak napas, dan batuk berdarah bisa jadi tanda orang sakit TB.",
	"Kalau orang lemas, tidak nafsu makan, dan berat badan turun, bisa jadi itu gejala TB.",
	"TB tidak bisa menular lewat batuk atau bersin dari orang yang sakit.",
	"Minum obat dengan teratur bisa membantu menyembuhkan TB.",
	"Menutup mulut saat batuk dan bersin bisa mencegah penyebaran TB ke orang lain.",
	"Dahak dari orang yang sakit TB tidak perlu dibuang di tempat khusus.",
	"Makan bergizi bisa membantu tubuh kita melawan penyakit TB."
]

const et01 = ref(null)
const et02 = ref(null)
const et03 = ref(null)
const et04 = ref(null)
const et05 = ref(null)
const et06 = ref(null)
const et07 = ref(null)
const et08 = ref(null)
const et09 = ref(null)
const et10 = ref(null)

var data = [
	{ tipe: "et", n: 1, a: et01.value, s: et01.value=="B"?1:0 },
	{ tipe: "et", n: 2, a: et02.value, s: et02.value=="S"?1:0 },
	{ tipe: "et", n: 3, a: et03.value, s: et03.value=="B"?1:0 },
	{ tipe: "et", n: 4, a: et04.value, s: et04.value=="B"?1:0 },
	{ tipe: "et", n: 5, a: et05.value, s: et05.value=="B"?1:0 },
	{ tipe: "et", n: 6, a: et06.value, s: et06.value=="S"?1:0 },
	{ tipe: "et", n: 7, a: et07.value, s: et07.value=="B"?1:0 },
	{ tipe: "et", n: 8, a: et08.value, s: et08.value=="B"?1:0 },
	{ tipe: "et", n: 9, a: et09.value, s: et09.value=="S"?1:0 },
	{ tipe: "et", n: 10, a: et10.value, s: et10.value=="B"?1:0 }
]

console.log(data)