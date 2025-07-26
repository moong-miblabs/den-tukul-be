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
		type: DataTypes.CHAR(1),
		comment: "answer; Y: Ya/Dilakukan; T: Tidak/Tidak Dilakukan;"
	},
	s: {
		type: DataTypes.SMALLINT,
		comment: "score"
	},
	result_id: {
		type: DataTypes.CHAR(21)
	}
}

const EvaluasiPraktik = sq.define('evaluasi_praktik',
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

UserRole.hasMany(EvaluasiPraktik, { foreignKey: 'user_role_id'})
EvaluasiPraktik.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiPraktik.allias = 'ep'

EvaluasiPraktik.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPraktik.allias}.${str}`).join(',');
}

EvaluasiPraktik.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiPraktik.allias}.${str} AS ${EvaluasiPraktik.allias}__${str}`).join(',');
}

export default EvaluasiPraktik