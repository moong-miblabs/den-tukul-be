class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Saya ingin mencegah TB karena saya merasa penting untuk menjaga kesehatan diri sendiri dan keluarga",
	"Saya merasa senang dan bangga jika dapat membantu orang lain memahami pentingnya pencegahan TB",
	"Mengetahui bahwa tindakan saya dapat mencegah penularan TB memberikan saya kepuasan",
	"Saya termotivasi mencegah TB karena adanya program pemerintah, seperti vaksinasi dan pemeriksaan gratis",
	"Saya terdorong untuk melakukan pencegahan TB karena keluarga atau teman saya mendukung tindakan tersebut",
	"Saya mencegah TB karena merasa malu jika tidak mematuhi anjuran dari tenaga kesehatan atau masyarakat",
	"Saya mencegah TB untuk melindungi kesehatan fisik saya (kebutuhan fisiologis).",
	"Saya merasa lebih aman jika melakukan tindakan pencegahan terhadap TB (kebutuhan keamanan).",
	"Saya merasa dihargai ketika orang lain melihat saya peduli terhadap pencegahan TB (kebutuhan penghargaan)",
	"Melakukan pencegahan TB membuat saya merasa berkontribusi pada masyarakat (kebutuhan aktualisasi diri)",
	"Apakah anda mendapat cukup informasi mengenai pencegahan TB dari tenaga kesehatan atau kampanye ?",
	"Apakah anda merasa lingkungan sekitar (keluarga/ teman/ masyarakat) mendukung tindakan pencegahan TB",
	"Apa faktor utama yang mendorong anda untuk melakukan pencegahan TB ?"
]

const em01 = ref(null)
const em02 = ref(null)
const em03 = ref(null)
const em04 = ref(null)
const em05 = ref(null)
const em06 = ref(null)
const em07 = ref(null)
const em08 = ref(null)
const em09 = ref(null)
const em10 = ref(null)
const em11 = ref(null)
const em12 = ref(null)
const em13 = ref(null)

var data = [
	{ tipe: "em", n: 'Aa01', a: em01.value },
	{ tipe: "em", n: 'Aa02', a: em02.value },
	{ tipe: "em", n: 'Aa03', a: em03.value },
	{ tipe: "em", n: 'Ab04', a: em04.value },
	{ tipe: "em", n: 'Ab05', a: em05.value },
	{ tipe: "em", n: 'Ab06', a: em06.value },
	{ tipe: "em", n: 'B001', a: em07.value },
	{ tipe: "em", n: 'B002', a: em08.value },
	{ tipe: "em", n: 'B003', a: em09.value },
	{ tipe: "em", n: 'B004', a: em10.value },
	{ tipe: "em", n: 'C001', a: em11.value },
	{ tipe: "em", n: 'C002', a: em12.value },
	{ tipe: "em", n: 'C003', a: em13.value }
]

console.log(data)