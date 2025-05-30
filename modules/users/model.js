import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import Provinsi from '../ref_provinsi/model.js'
import KabKota from '../ref_kab_kota/model.js'
import Kecamatan from '../ref_kecamatan/model.js'
import Kelurahan from '../ref_kelurahan/model.js'
import Agama from '../ref_agama/model.js'
import Pekerjaan from '../ref_pekerjaan/model.js'
import Penghasilan from '../ref_penghasilan/model.js'
import Jenjang from '../ref_jenjang/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	sso_id: {
		type: DataTypes.STRING
	}, 
	nama_user: {
		type: DataTypes.STRING
	},
	email_user: {
		type: DataTypes.STRING
	},
	email_code: {
		type: DataTypes.CHAR(6)
	},
	email_expired_at: {
		type: DataTypes.DATE
	},
	email_verified_at: {
		type: DataTypes.DATE
	},
	whatsapp_user: {
		type: DataTypes.STRING
	},
	whatsapp_code: {
		type: DataTypes.CHAR(6)
	},
	whatsapp_expired_at: {
		type: DataTypes.DATE
	},
	whatsapp_verified_at: {
		type: DataTypes.DATE
	},
	username_user: {
		type: DataTypes.STRING
	},
	password_user: {
		type: DataTypes.STRING
	},
	code: {
		type: DataTypes.STRING
	},
	code_expired_at: {
		type: DataTypes.DATE
	},
	enrolled_by: {
		type: DataTypes.JSON
	},
	enroll_code: {
		type: DataTypes.CHAR(6)
	},
	enroll_expired_at: {
		type: DataTypes.DATE
	},
	provinsi_id: {
		type: DataTypes.CHAR(6)
	},
	kab_kota_id: {
		type: DataTypes.CHAR(6)
	},
	kecamatan_id: {
		type: DataTypes.CHAR(6)
	},
	kelurahan_id: {
		type: DataTypes.CHAR(10)
	},
	jenis_kelamin: {
		type: DataTypes.CHAR(1),
		comment: 'L: Laki; P: Perempuan;'
	},
	marital: {
		type: DataTypes.CHAR(1),
		comment: 'S: Single; M: Menikah; D: Cerai; W: ditinggal Mati;'
	},
	tempat_lahir: {
		type: DataTypes.STRING
	},
	tanggal_lahir: {
		type: DataTypes.DATEONLY
	},
	nik: {
		type: DataTypes.CHAR(16)
	},
	jalan: {
		type: DataTypes.STRING
	},
	dusun: {
		type: DataTypes.STRING
	},
	rt: {
		type: DataTypes.CHAR(5)
	},
	rw: {
		type: DataTypes.CHAR(5)
	},
	no_rumah: {
		type: DataTypes.STRING(100)
	},
	blok: {
		type: DataTypes.STRING
	},
	kode_pos: {
		type: DataTypes.INTEGER
	},
	agama_id : {
		type: DataTypes.SMALLINT
	},
	pekerjaan_id : {
		type: DataTypes.SMALLINT
	},
	penghasilan_id : {
		type: DataTypes.SMALLINT
	},
	jenjang_id : {
		type: DataTypes.SMALLINT
	},
	foto_profil: {
		type: DataTypes.TEXT
	},
	tentang: {
		type: DataTypes.TEXT
	}
}

const Users = sq.define('users',
	columns,
	{
		freezeTableName: true,
	    timestamps: true,
	    createdAt: 'created_at',
	    updatedAt: 'updated_at',
	    paranoid: true,
	    deletedAt: 'deleted_at',
	}
)

Provinsi.hasMany(Users, { foreignKey: 'provinsi_id' })
Users.belongsTo(Provinsi, { foreignKey: 'provinsi_id' })

KabKota.hasMany(Users,{ foreignKey: 'kab_kota_id' })
Users.belongsTo(KabKota, { foreignKey: 'kab_kota_id' })

Kecamatan.hasMany(Users,{ foreignKey: 'kecamatan_id' })
Users.belongsTo(Kecamatan, { foreignKey: 'kecamatan_id' })

Kelurahan.hasMany(Users,{ foreignKey: 'kelurahan_id' })
Users.belongsTo(Kelurahan, { foreignKey: 'kelurahan_id' })

Agama.hasMany(Users, { foreignKey: 'agama_id' })
Users.belongsTo(Agama, { foreignKey: 'agama_id' })

Pekerjaan.hasMany(Users, { foreignKey: 'pekerjaan_id' })
Users.belongsTo(Pekerjaan, { foreignKey: 'pekerjaan_id' })

Penghasilan.hasMany(Users, { foreignKey: 'penghasilan_id' })
Users.belongsTo(Penghasilan, { foreignKey: 'penghasilan_id' })

Jenjang.hasMany(Users, { foreignKey: 'jenjang_id' })
Users.belongsTo(Jenjang, { foreignKey: 'jenjang_id' })

Users.allias = 'uu'

Users.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Users.allias}.${str}`).join(',');
}

Users.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Users.allias}.${str} AS ${Users.allias}__${str}`).join(',');
}

export default Users