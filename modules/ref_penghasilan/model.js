import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.SMALLINT,
		primaryKey: true
	},
	nama_penghasilan: {
		type: DataTypes.STRING
	}
}

const Penghasilan = sq.define('ref_penghasilan',
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

Penghasilan.allias = 'ph'

Penghasilan.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Penghasilan.allias}.${str}`).join(',');
}

Penghasilan.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Penghasilan.allias}.${str} AS ${Penghasilan.allias}__${str}`).join(',');
}

export default Penghasilan