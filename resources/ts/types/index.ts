export type User = {
    id: number,
    name: string // username
    email: string,
    phone?: string,
    first_name: string,
    last_name?: string,
    full_name?: string,
    role: string,
    status: string,
    date_of_birth?: Date,
    timezone?: string,
    email_verified_at?: Date,
    email_verified_at_w3c?: Date,
    phone_verified_at?: Date,
    phone_verified_at_w3c?: Date,
    last_login_at?: Date,
    last_login_at_w3c?: Date,
    created_at?: Date,
    created_at_w3c?: Date,
    updated_at?: Date,
    updated_at_w3c?: Date,
    verified_at?: Date,
    verified_at_w3c?: Date,
    avatar_url?: string,
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

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


export type Testimonial = {
    id: number,
    user_id?: number,
    names: string,
    position?: string,
    company?: string,
    country?: string,
    content: string,
    is_approved: boolean,
    created_at: Date,
    updated_at?: Date,
}
