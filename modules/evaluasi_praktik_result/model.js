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
	t: {
		type: DataTypes.SMALLINT,
		comment: "number"
	},
	c: {
		type: DataTypes.TEXT,
		comment: "class"
	}
}

const EvaluasiPraktikResult = sq.define('evaluasi_praktik_result',
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

UserRole.hasMany(EvaluasiPraktikResult, { foreignKey: 'user_role_id'})
EvaluasiPraktikResult.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiPraktikResult.allias = 'ph'

EvaluasiPraktikResult.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPraktikResult.allias}.${str}`).join(',');
}

EvaluasiPraktikResult.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPraktikResult.allias}.${str} AS ${EvaluasiPraktikResult.allias}__${str}`).join(',');
}

export default EvaluasiPraktikResult