class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Tuberculosis paru adalah suatu penyakit infeksi yang disebabkan oleh bakteri Microbakterium Tuberkulosa",
	"Penyakit tuberculosis dapat menular melalui alat makan.",
	"Gejala yang dirasakan penderita tuberculosis adalah batuk lebih dari 3 minggu, demam dan disertai influenza",
	"Nyeri dada, sesak napas dan batuk berdarah adalah tanda dan gejala penderita penyakit tuberculosis.",
	"Badan lemah, nafsu makan menurun, berat badan turun, kurang enak badan bukan merupakan gejala-gejala tuberculosis",
	"Penyakit Tuberculosis tidak dapat ditularkan melalui percikan dahak dan bersin penderita tuberculosis",
	"Apakah Minum obat dengan teratur termasuk kedalam pencegahan penyakit tuberculosis",
	"Menutup mulut waktu batuk dan bersin termasuk dalam pencegahan tuberculosis",
	"Dahak penderita tuberculosis tidak perlu ditampung dalam wadah khusus",
	"Meningkatkan daya tahan tubuh dengan makan makanan yang bergizi termasuk kedalam pencegahan penyakit tuberculosis"
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
	{ tipe: "et", n: 1, a: et01.value },
	{ tipe: "et", n: 2, a: et02.value },
	{ tipe: "et", n: 3, a: et03.value },
	{ tipe: "et", n: 4, a: et04.value },
	{ tipe: "et", n: 5, a: et05.value },
	{ tipe: "et", n: 6, a: et06.value },
	{ tipe: "et", n: 7, a: et07.value },
	{ tipe: "et", n: 8, a: et08.value },
	{ tipe: "et", n: 9, a: et09.value },
	{ tipe: "et", n: 10, a: et10.value }
]

console.log(data)