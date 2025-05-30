class Ref {
	constructor(val) {
		this.value = val
	}
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Saya merasa didukung oleh keluarga dalam menjaga kesehatan untuk mencegah ",
	"Saya merasa teman atau tetangga peduli terhadap kesehatan saya dan memberi motivasi untuk mencegah TB",
	"Saya merasa nyaman untuk berbicara tentang pencegahan TB dengan keluarga atau teman",
	"Keluarga saya membantu menyediakan fasilitas seperti masker atau menjaga kebersihan rumah untuk mencegahTB",
	"Saya merasa mendapatkan bantuan logistik (seperti akses ke fasilitas kesehatan) dari pemerintah atau masyarakat",
	"Saya merasa orang disekitar saya membantu saya jika saya membutuhkan pemeriksaan kesehatan untuk TB",
	"Saya mendapatkan informasi yang cukup tentang pencegahan TB dari tenaga kesehatan",
	"Saya merasa keluarga atau teman sering memberikan saran tentang pentingnya mencegah TB",
	"Saya merasa informasi tentang pencegahan TB mudah diakses di lingkungan saya (seperti poster, kampanye kesehatan)",
	"Keluarga saya memberikan dukungan dengan memuji atau mendorong saya untuk tetap menjaga kesehatan",
	"Saya merasa teman atau masyarakat memberikan apresiasi atas tindakan saya dalam mencegah TB",
	"Saya sering berdiskusi dengan tenaga kesehatan tentang langkah-langkah pencegahan TB yang tepat",
	"Apakah anda merasa lingkungan anda mendukung pencegahan TB ?",
	"Faktor utama apa yang paling membantu anda dalam mencegah TB ?"
]

const ed01 = ref(null)
const ed02 = ref(null)
const ed03 = ref(null)
const ed04 = ref(null)
const ed05 = ref(null)
const ed06 = ref(null)
const ed07 = ref(null)
const ed08 = ref(null)
const ed09 = ref(null)
const ed10 = ref(null)
const ed11 = ref(null)
const ed12 = ref(null)
const ed13 = ref(null)
const ed14 = ref(null)

var data = [
	{ tipe: "ed", n: 'Dc07', a: ed01.value },
	{ tipe: "ed", n: 'Dc08', a: ed02.value },
	{ tipe: "ed", n: 'Dc09', a: ed03.value },
	{ tipe: "ed", n: 'Dd10', a: ed04.value },
	{ tipe: "ed", n: 'Dd11', a: ed05.value },
	{ tipe: "ed", n: 'Dd12', a: ed06.value },
	{ tipe: "ed", n: 'De13', a: ed07.value },
	{ tipe: "ed", n: 'De14', a: ed08.value },
	{ tipe: "ed", n: 'De15', a: ed09.value },
	{ tipe: "ed", n: 'Df16', a: ed10.value },
	{ tipe: "ed", n: 'Df17', a: ed11.value },
	{ tipe: "ed", n: 'Df18', a: ed12.value },
	{ tipe: "ed", n: 'E004', a: ed13.value },
	{ tipe: "ed", n: 'E005', a: ed14.value },
]

console.log(data)