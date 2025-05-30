import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.SMALLINT,
		primaryKey: true
	},
	nama_pekerjaan: {
		type: DataTypes.STRING
	}
}

const Pekerjaan = sq.define('ref_pekerjaan',
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

Pekerjaan.allias = 'pk'

Pekerjaan.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Pekerjaan.allias}.${str}`).join(',');
}

Pekerjaan.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Pekerjaan.allias}.${str} AS ${Pekerjaan.allias}__${str}`).join(',');
}

export default Pekerjaan