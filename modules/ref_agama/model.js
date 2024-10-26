import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.SMALLINT,
		primaryKey: true
	},
	nama_agama: {
		type: DataTypes.STRING
	}
}

let agama = 'ag'

const Agama = sq.define('ref_agama',
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

export default Agama