class Ref {
	constructor(val) {
		this.value = val
	}
}
function linkertSetuju(char) {
    if(char=='SS') return 4
    if(char=='S0') return 3
    if(char=='T0') return 2
    if(char=='ST') return 1
}
const ref = (val) => new Ref(val)

const PERTANYAAN = [
	"Sekolah mengajari saya cara mencegah penyakit TB secara rutin.",
	"Sekolah menyediakan tempat cuci tangan dengan sabun agar tangan saya tetap bersih.",
	"Jika ada siswa yang sakit, sekolah menyarankan agar istirahat di rumah.",
	"Guru dan staf sekolah memberikan contoh hidup bersih dan sehat.",
	"Sekolah punya program pemeriksaan kesehatan untuk mengetahui penyakit seperti TB.",
	"Setiap kelas punya jendela atau ventilasi agar udara di kelas bisa berganti.",
	"Sekolah memberi informasi penting tentang suntik BCG untuk mencegah TB.",
	"Sekolah bekerja sama dengan puskesmas atau tempat kesehatan untuk mencegah penyakit TB.",
	"Sekolah mengadakan kegiatan edukasi untuk mengingatkan bahaya penyakit TB.",
	"Sekolah mendukung siswa agar periksa ke dokter kalau mengalami gejala TB."
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

var data = [
	{ tipe: "ed", n: 'Dc07', a: ed01.value, s: linkertSetuju(ed01.value) },
	{ tipe: "ed", n: 'Dc08', a: ed02.value, s: linkertSetuju(ed02.value) },
	{ tipe: "ed", n: 'Dc09', a: ed03.value, s: linkertSetuju(ed03.value) },
	{ tipe: "ed", n: 'Dd10', a: ed04.value, s: linkertSetuju(ed04.value) },
	{ tipe: "ed", n: 'Dd11', a: ed05.value, s: linkertSetuju(ed05.value) },
	{ tipe: "ed", n: 'Dd12', a: ed06.value, s: linkertSetuju(ed06.value) },
	{ tipe: "ed", n: 'De13', a: ed07.value, s: linkertSetuju(ed07.value) },
	{ tipe: "ed", n: 'De14', a: ed08.value, s: linkertSetuju(ed08.value) },
	{ tipe: "ed", n: 'De15', a: ed09.value, s: linkertSetuju(ed09.value) },
	{ tipe: "ed", n: 'Df16', a: ed10.value, s: linkertSetuju(ed10.value) },
]

console.log(data)