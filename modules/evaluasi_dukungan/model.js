import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import UserRole from '../user_role/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	user_role_id: {
		type: DataTypes.CHAR(21),
	},
	n: {
		type: DataTypes.CHAR(4),
		comment: "number e.g Aa01,Aa02,Aa03,Ab04"
	},
	a: {
		type: DataTypes.CHAR(2),
		comment: "P1: Sangat Setuju; P0: Setuju; N0: Tidak Setuju; N1: Sangat Tidak Setuju; TT: Ya; FF: Tidak"
	}
}

const EvaluasiDukungan = sq.define('evaluasi_dukungan',
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

UserRole.hasMany(EvaluasiDukungan, { foreignKey: 'user_role_id'})
EvaluasiDukungan.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiDukungan.allias = 'ed'

EvaluasiDukungan.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiDukungan.allias}.${str}`).join(',');
}

EvaluasiDukungan.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiDukungan.allias}.${str} AS ${EvaluasiDukungan.allias}__${str}`).join(',');
}

export default EvaluasiDukungan