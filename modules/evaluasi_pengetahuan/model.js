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
		type: DataTypes.SMALLINT,
		comment: "number"
	},
	a: {
		type: DataTypes.SMALLINT,
		comment: "answer"
	}
}

const EvaluasiPengetahuan = sq.define('evaluasi_pengetahuan',
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

UserRole.hasMany(EvaluasiPengetahuan, { foreignKey: 'user_role_id'})
EvaluasiPengetahuan.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiPengetahuan.allias = 'et'

EvaluasiPengetahuan.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPengetahuan.allias}.${str}`).join(',');
}

EvaluasiPengetahuan.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPengetahuan.allias}.${str} AS ${EvaluasiPengetahuan.allias}__${str}`).join(',');
}

export default EvaluasiPengetahuan