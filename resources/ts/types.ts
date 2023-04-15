export type ResetSystemAction = {
    text: string,
    action: string,
}

export type SystemConfiguration = {
    id: number,
    name: string,
    type: 'bool' | 'text' | 'number',
    value?: string | boolean | number,
    created_at: Date,
    updated_at: Date,
    default?: string,
    description?: string,
    hint?: string,
}

export type PaginationMeta = {
    current_page: number,
    from: 1,
    to: number,
    total: number,
    path: string,
    last_page: number,
    per_page: number,
}

export type TableHeader = {
    text: string
    align: 'left' | 'right' | 'center'
}

export type ContactMessage = {
    id?: number,
    name: string,
    subject: string,
    body: string,
    phone?: string,
    email?: string,
    last_read_at?: Date,
    last_read_at_w3c?: Date,
}
