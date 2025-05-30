import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import Kecamatan from '../ref_kecamatan/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(10),
		primaryKey: true
	},
	kecamatan_id: {
		type: DataTypes.CHAR(6),
	},
	nama_kelurahan: {
		type: DataTypes.STRING
	},
	level_wilayah: {
		type: DataTypes.SMALLINT,
		defaultValue: 4
	}
}

const Kelurahan = sq.define('ref_kelurahan',
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

Kecamatan.hasMany(Kelurahan, { foreignKey: 'kecamatan_id' })
Kelurahan.belongsTo(Kecamatan, { foreignKey: 'kecamatan_id' })

Kelurahan.allias = 'kl'

Kelurahan.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	/*===*/ arr.push('created_at'); arr.push('updated_at'); 
	return arr.map(str => `${Kelurahan.allias}.${str}`).join(',');
}

Kelurahan.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	/*===*/ arr.push('created_at'); arr.push('updated_at'); 
	return arr.map(str => `${Kelurahan.allias}.${str} AS ${Kelurahan.allias}__${str}`).join(',');
}

export default Kelurahan