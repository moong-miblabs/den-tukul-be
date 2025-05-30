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

const EvaluasiMotivasi = sq.define('evaluasi_motivasi',
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

UserRole.hasMany(EvaluasiMotivasi, { foreignKey: 'user_role_id'})
EvaluasiMotivasi.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiMotivasi.allias = 'em'

EvaluasiMotivasi.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiMotivasi.allias}.${str}`).join(',');
}

EvaluasiMotivasi.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiMotivasi.allias}.${str} AS ${EvaluasiMotivasi.allias}__${str}`).join(',');
}

export default EvaluasiMotivasi